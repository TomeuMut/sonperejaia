<?php namespace Bmut\Utils\Classes\Helpers;

use Cache;
use Exception;
use Model;
use File as FileHelper;
use October\Rain\Resize\Resizer;
use Bmut\Utils\Models\Settings;
use System\Models\File as BaseFile;

/**
 * @deprecated
 */
class File extends BaseFile
{
    public $generatedName;

    public function getThumbFilename($width, $height, $options)
    {
        $newName = $this->file_name;
        $extension = null;
        $baseName = explode('.', $this->file_name);
        if ((is_array($baseName)) && (count($baseName) > 1)) {
            $extension = '.' . array_pop($baseName);
            $newName = implode('-', $baseName);
        }

        $sluggified = str_slug($newName, '-') . $extension;

        return $sluggified;
    }

    /**
     * Generates and returns a thumbnail path.
     */
    public function getThumb($width, $height, $options = [])
    {
        if (!$this->isImage()) {
            return $this->getPath();
        }

        $width = (int) $width;
        $height = (int) $height;

        $options = $this->getDefaultThumbOptions($options);

        $thumbFile = $this->getThumbFilename($width, $height, $options);
        $this->makeThumbDir($width, $height);

        $thumbPath = $this->getStorageDirectory() . $this->getPartitionDirectory()
            . $width . 'x' . $height . '/'
            . $thumbFile;
        $thumbPublic = $this->getPublicPath() . $this->getPartitionDirectory()
            . $width . 'x' . $height . '/'
            . $thumbFile;

        if (!$this->hasFile($thumbPath)) {
            if ($this->isLocalStorage()) {
                $this->makeThumbLocal($thumbFile, $thumbPath, $width, $height, $options);
            } else {
                $this->makeThumbStorage($thumbFile, $thumbPath, $width, $height, $options);
            }
        }

        return $thumbPublic;
    }

    /**
     * Check file exists on storage device.
     * @return void
     */
     /*
     En la última versión de october ha empezado a fallar, si usamos el método original de october pasandole el parametro que queremos, va bien.
    protected function hasFile($filePath = null)
    {
        try {

            $result = Cache::rememberForever($this->getCacheKey($filePath), function () use ($filePath) {
                return $this->storageCmd('exists', $filePath);
            });

            // Forget negative results
            if (!$result) {
                Cache::forget($this->getCacheKey($filePath));
            }
        } catch (Exception $e) {
            $result = $this->storageCmd('exists', $filePath);
        }

        return $result;
    }
*/
    /**
     * After model is deleted
     * - clean up it's thumbnails
     */
    public function afterDelete()
    {
        try {
            $this->deleteThumbs();
            $this->deleteSeoThumb();
            $this->deleteFile();
        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
        }
    }

    /*
     * Delete all thumbnails for this file.
     */
    protected function deleteSeoThumb()
    {
        $directory = $this->getStorageDirectory() . $this->getPartitionDirectory();
        $thumbDirs = $this->storageCmd('directories', $directory);
        //Quiza borrar las imágenes dentro de esos directorios que tengan como nombre el getThumbFilename;

        if ($thumbDirs) {
            try {
                if ($this->isLocalStorage()) {
                    foreach ($thumbDirs as $dir) {
                        FileHelper::deleteDirectory($dir);
                    }
                } else {
                    foreach ($thumbDirs as $dir) {
                        Storage::deleteDirectory($dir);
                    }
                }
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
            }
        }
    }

    /**
     * Generate thumbs directory.
     */
    private function makeThumbDir($width, $height)
    {
        $path = $this->getStorageDirectory() . $this->getPartitionDirectory() . $width . 'x' . $height;
        if ($this->storageCmd('exists', $path)) {
            return;
        }
        try {
            $this->storageCmd('makeDirectory', $path);
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
        }
    }



    /**
     * Generate the thumbnail based on the local file system. This step is necessary
     * to simplify things and ensure the correct file permissions are given
     * to the local files.
     */
    protected function makeThumbLocal($thumbFile, $thumbPath, $width, $height, $options)
    {
        $rootPath = $this->getLocalRootPath();
        $filePath = $rootPath.'/'.$this->getDiskPath();
        $thumbPath = $rootPath.'/'.$thumbPath;

        /*
         * Handle a broken source image
         */
        if (!$this->hasFile($this->disk_name)) {
            $this->copyTo($thumbPath);
        }
        /*
         * Generate thumbnail
         */
        else {
            try {
                Resizer::open($filePath)
                    ->resize($width, $height, $options)
                    ->save($thumbPath)
                ;
            }
            catch (Exception $ex) {
                $this->copyTo($thumbPath);
            }
        }

        FileHelper::chmod($thumbPath);
    }

    /**
     * @param $savePath Dirname where the image will be stored
     */
    public function copyTo($savePath)
    {
        /*
         * Check if save path directory exists
         */
        $directoryPath = dirname($savePath);
        if (!FileHelper::exists($directoryPath)) {
            FileHelper::makeDirectory($directoryPath, 0777, true);
        }

        /*
         * Save broken file image
         */
        if ($file = Settings::instance()->broken_image) {
            $image = file_get_contents($file->getPath());
        }


        FileHelper::put($savePath, $image ?? base64_decode('iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAMAAACahl6sAAAAZlBMVEXIRTDy8vL8/Pv////k5OT39/fz8/Px8fH09PT19fXw8PDm5ebv7+/q6un29vbu7u7t7e35+fn9/f36+vrs7Ozr6+v+/v7n5+fo6OjozsrPZFLfpZzt3Nrku7TVe2zLUj/akIX26eeozQupAAAUKElEQVR42rSc63LaMBCFSSckwQ7gTNMh3On7v2QlkPWxWu0aCt5C+6Mz7Xw9OnuT3clLH+/v7/HbvDeX+LzEMnxidDm+v7vvEH++/4SYh48ZP1exWq3CN8TrxIrja/v635FBAkWEKVAiSCZJMIEjRSSJLBZHILmCSSBbE2T7GkjaB0DQJEVTiNIHmvQkicVRBY5LtEdHkPb8eQAEVSBRp6sTKHB4sqBJIDnDrG1BWgR5niKJpKlK8i1RIkX42VFkjigHEySo0cLxFEWanuUza7JMmvQgnK0cWEOSCNPvHEFiuJr4IG8vRLZ7cjw0JomyCSSIQmw9QZIk/6XL5A0QwyhNxMii5OSVcrAwinG2CKxuCHKBaMPnfpACJZSTpAp6oElUJaXgjhz8DYgPs/cFEaervRPkpQdBEUhgQZLwxfAxwADFANkMCQLI3YrYZyuBIElk6RAlfBIH4YPsPEGI/ymMkw9AtOWxSYPhr9MwuWvocPlWPyUESBDmdkUiSkGTFIEk6YJNJAjny6uLq0FBOFyR5l6QGDUQUGi8sElKXB05+AJi0GD1IUFgeVwRUnD8phScWMpeOAcoRgs535iCrFodd3skhQDJh6uXJHJQT0QHCQsgtbCtfjI4lFN8kA9AVD3RrbCWpLswYBMrTsMOIUC4FaTniD9k4JOkSXPmKBxPEk4dpNULr2yHrOIPA+UizU0gH4lEVUaRvD6TKktzPqGYVGUxrb5bgeH7ZBgkRbWcNAmEctKPJ3AkFrcybkyHxDBg7gEBRZcTPG80XkISt39c24K0Z45Wk7yqIu+BxDAU0Z2wnBnzIB806Wjrq2fr5AkSWAyXtLd6ZAYHogifqNSFT7Qo5vDb2oIQTl0cVgQSKwn3LKAgCs2KtAkFfsDqh7RcsU7XzSCzABJJklEQRM+/hSaAFENjtas/WoL8ABLPl5WGh0EukuB4BhQOF0aBBL8vqSZF4wXJ2hIEDscpl2iHFVEoShA04XCVYzxG0SY52IIIFEqjMTE6IBFlxumqni84qIy5zHdqPEGRRPNqCrJKJChi+GQQJHEky2MUlYfxO6IkEjxf+iTF1hKEbSp+1+mLzYoHEqNHSd0K7Qog2ISeXiZhhl984lv9IPapfhqOMQwSOLzKiEkiim7rmRnrc/zaFkSh0EGWmvhmX0ByNorlE1YrKdSSyMjCEeRwgyCgxBxs+GQY5EMkL2eOBwWO+szI7GtZfV1eOdA8Glm4dUAWGWVWJGECTZqiq18KGEQRvcrWEETsIYUoZlvvgczOKIDgFLWCPKPoviuhSE2Asay+PmOgSRIGFO0UFyRwIEpp+TdjkEcTa2pEE8PqGwSpiFLahLVw64IsCqN4yUsanoZF7rdpWA6WIDGkKlCAIXKwiTKZxoMVYZIodjfM6dKlkcVwzwHJzhBEXQQVPZczMBogMWY5EAQUcwdJDgbkgsKlw9YTRPr9lsJoemQKiPD8QFMf0hd1ERqycFbEEETfaK1goROGBpbWVgQWmvrEogKfqOTFipvr+LUrCIpoo7hbIg3SSyJJKPLVNREgVEZjS7SxBCEMEhic+ReQ6VQqMoOjXk0SSsOeqBi1xBJy5whCCA5IrNLIgAJI5Jhmxy9IXCGSJMYSkgZSD40IcqoL8qNA5pLDT8PcMgISJUEUozACguGpjIiSApS5I4hzugjGeIVTAcHwC0lC9pIl/oW2XhbGssLvBx1C9jJQWjcNt4DE0NVEriSsNGwYnnqysQXxRBF6OKURFkCK84UgFolu6mm7unS+dqYgPof0Sn3dhSqAxChJkKTKQT0BRU+/davvy2sHKiMgRMvpstdEgJC7CEqjvo5XIKwgM4hpdeshCTGfAGN3K5lmAkchyVUSNgoKLHDIzsvakx63O/dCXqtiXs5xtIicuaqpC1HQRIIon3RYXftk/+qi4BJvM1wqgkumuS6CwVq4WEJKlAgi0xdWN1hWhk9gMeq7fgBn8iVIaCAp8kgCh560ascLq1txWP8YKJwut/GijnxBAkySBFkgcYdGuYLE6l6cYKmAgGKIkgQRitCtAGM7HpD4U1PJwlh9iGVndyu+5XH8ZIokFct/wGKsicpnJBClM5YnZhoDRYjiccAy+QogGmWWHV+7P5GF0boIMiaqwTTG6WIJSYG3KuMZZFqgLIp6AsmHUqQEQRNjeeKzGA/Z0tUblkcRKAChgZxJn5SasEylolhW9+OQUnImWdldFxwJBBS7MkaSrAggJcvV4m57NwRpDA7dDdfjcrTk6dKDVgYxW8g+0GQZrf4Ai+SQqztNE82eopBkqg6XzMElTUnSWFa/PY1FVQCp7lIJQEqUHP3+MfxizSfANDmw+gMsgJC7jBXkNQgoC7FbyShFOSk0QZDw8+oxCNJYZinvfmFY70+hO/1dV4Tpl119isGZMZJg9YdZWmQpE/Fuvc3KC0UCzBcY55/gkDmY7EUvjFE+H7G67ixXSpMkAxEU+W2JwulikIfFuo9v4sew+gNpLGBcVEEGGb/hqBeU2fkLhnURxKjlWP2xlIwMVZBI8lscLz3Gs+8SIFZF0VYfP+CwT5eujDilOv1u3Z4duZ4MAspUHS4q4+CkxZLo06sOf5bd+jh5fuy+AIkYoFDiQXHGEzRxrb5mk/rkOO5nheGlJJmmXHd9mCgbJ5WmvfD89EwGji1JuALDPkKKYhVGb3nS5g33OFbZ7KdQGKmLvl4M8rqaOP/Y2+tV/RrlnirLX0iEJIu872IhwXyiS6Nj9U1xN7fH9U+VZT212y45anl9195xevlK0LOtgvRZFk1CZWTQ4ulUYmOLvtSPcGOVJ8fBkoVtFyhIQrPiWH3+eQWy7O9Ln24VBpp3fKJ29YJDPanmWn2fbx268OEd0+dbBVl2tPRGu8KuXr628ek4nZ1X0qR/dlA9vPnMMvlWqY3SJ2iSUHyr71gL6/v41xGsQpn8Mqf4koTcdTT/uMp9PDXlexyr0L3IOd5+2iNixM/O/LOWeQu5TFG+zTiKVSiTciPRo7CQkAOKafU1u3qVhLuEMo5VKJOLSj1BE2H4zkwfvCsrT5d8wGskq1AmFUkJknxiWn3eZJIGEvX44HhWQRYbBaeYVt/qF2nU6UoxV1YZTZZyZKTIW1bf5E09LOSt8BHPPY9mFcokHPUqf7CczmuAIcp3goj00sZ4ViEfvwcSDZJeP/lrpb50yyifVIMDkPyKwHhWQZZFbrtKm1hHoovzrz5coi6qV0xHtArdy2IKCBdBb8ZfvX+x/i8fchf/c0xm+RnRKnQvoKCJ9ej4O5u7HkSKYrzeNKpVGPI/RC8cv8Zfu4NDvIqtSNR7/iNbhXws2xXD6lvjeWFOl7RJJ/63lXGrCmUyUOTY1h3VFBvu9FwBLMyM+r9bucMqp0dlmfW3c8d6CdEXpkhSb4aLd8rn7U1W+fVrtz0+NuRfBFnXf9d5WbZXBFHqr5XP51jFAYnxr7WzXU4iCKIoboyIZSXubkkVBBJ4/5eUhQmH/l6CreX/45073dsz0xz324c+8o8nEP+/7eiBYJPGAgiayOFwtVW6FsvN+0NpcuevPH/AEo5HEgRhIgbP42urdES/Ofzv3cAcBTGvb5lNLDj9aYLMtkonYsQw/yN2+iAIkibI5e+rTYzXaJqUVukGiYJhHo9DfefuN0ne87uYDJdbRXNgmMfjFRCH5NYmtO5EarRvTLGKo4jL8vy4Yfa06t2bz6wv/QaQISXtpRYkoVUGgfE/DbP9wWNZJQlGaQEJTuEBsxgkgVXM0gLFsjxgmCMd7mp5sbSUT5jmg+WxilKkQBm/aJg3eisWpZpsCcpFElwfvvTvugsHLKMEmeILhvn4dgLhHU32CBBNVGqEpKEw9cpaZbhIkmoyRX+nYTZcwcn3rqU/AVa3VuyITqwCyDCAolUZiTsM807rzp165VyrV2Mk1CejM6NEWmVoYSXxWWYa5qgOGu2FzuC1rB4vjChMKWkoMqtcMTLPjw2mn/6+zDDMXrS7WsQZni4RM0pAyYZefT8YRUiMDsiFg3srhWG2P+3d52lxAYMkZEZAfgeVF4mR2G0BORFM/8Tra5xIQJlinxaL7iPTeO+iU58cO/wlxSMKVlkjSe0TNBnTm0z6TIu9qxoAK1v1xihmcWGVNSRZXjSSZJ5ftoNG+8TUOH4iAYTVZRcXMKDcWEUqkhleLa0shfDawZuHAcySq6kkRrm84qpeBWbHJOnW1eJn4vQVx4z5FBwkueZ4ZKlGD2qQ9XquS+Dox/GYpJDgIIgzUzfDm0EldLjDTRgcCdJRrxRO6ZOp6c6Vu5U/exBNGoseFUW9AggsGmQQAUbmk3j3/fhpb6qRTfIXzFgelD9qLpF1CoqsDcdQ+iQ+hhZHWiiSkPinDrYjwRwJQoGsB7HCZuzD26hYlJfucHyuSXN81OGmFjY+AQSIyvBI0oW77y9A/AP5FvWnVjQsigISEpaWWF2FIhPKMioW/QdnnPzi+PxJkBrm8ykJIIxUA6SxnP6Q4QvHR2N06is4SGJC+cR2u+iuSE0mnEXDGNa3IFOkJJugWHTfmOrbwo2jtHyL69wYMGQ7tSnyNJGAMcfxY1AyHsAQqsjMWK+upSFBFEhoEwEyBZqgR8jil4w/FIh6mXmFqZpEQWvFPcVGkSvJWifGJJ18uCmkBwIWRqqZJ6Z1686fw03DC5hmdlBwSoLS+043d9GnP+Llr7nQ6Q9f0C5BkQuO7Xb9XSDINaOAEsXRLRbPHL0L0jRhfBffjLZa+WWTvL1acIVpDYnFhePphmWG4Tdesei8AvT83lDymQXIoj9Pgl9yuSjyhCpy84pA9k6x+GxBQFmZsh4Un4TOii29MDxf8mdFsMjMr5OD4/T8ddNKJ0YxvCskgcOOTaUWbiBnPQRPsHfRgdzaYnGMQPSAJabyBt8nbFyfLApFtyCbIoJhXgk5Ov2GfuwbS/hAHqvYzFgPGyXHY3g24RPIOdaCR3A4LCtbLI4jIBOKgmkQ18yY94VhufqEzevPhGKOHS5Ly6gy/Yk3L+eDvR8Via8Jnm+ShPNfZZtIt+5Mj6gpsm40DUcvrenfYvcdCxA+f/1PLStJs4kkaekEz1PVn0CaImccavpsF37zQaxL7D7MApM2SQdb/jb5xDbrmyJnMVDk8ldEXjJ2jYSQMMFAjIaRV8N0JAAx17sAwSfRNkx8BIqgis0mdopi8cb0FE4L8rUdxyMJihCKYg0Ge5dfMlqOPlxc9FLzN+XLaOCKPsWWIG1lCV0Cpxx9kK6tLiTpg1IYUZLh1VSQfGjFDwQAabuWyPICg0/53SJfWtLz6ZSSpC1Mllf3CvhkZOsCRGdFUorNjPsAhPAsTzrh88S+nAv6wmRGUMSVzgZCIMlw65SusbD7yqBTrxyvrGKeysKS/woVp1rmXj0gRhTyu2v4dx+kE4I0FA1CYBN6K5BoFlDEUN6WUAAJ9y5Y0GThgeSLy5KwuLLPXzqQxfsTB0TtW7Zg6V2QW0l6QRIZXreJgu9421xxx40GijwZDAx/dEB6e2I61q/KMUqyc+nDX3OKbUFIKOnWtUlBiGIGDqmx+kDRKKyuGMTmE2uUfQTi+iSf3/VyX4tbl5CAvAJi/C6/tEA5BCCwkOL9iRhtfXGGXYwlsm0763gDQlkvDU+HexuBJKrEvVRKYRpe9gaOqoVrEEJ/MEKycEEIIOy8FVCCTTgcWG9++7OBtNQISMBhF9cqBuHaCihjXgwzfEHXj35XGE3UG1NAXBpEuaqyKxWhXiHDBwNX7CAy8onfj7D3CgCJTfLk9FI3HsizPJ1rKHLYik4nvMy8q0mk53BP/5SKKNOf4y0EIaJ00uffjPnpHFeJ9E9tAFKvLTR5j0EIiwGKXV1WlYkClqrySj2CKMr0H7MVseWK4oCEXTgcLowoOD4HAQKzoEq3KEEwvVMJ9/FwOFgwSjmvvgUgmeVvm/XHCKRwCThCEp0aTSkckiz5zqpBKIavLLsCBBRBY3yCTWyzPvsdU3qp8qdlF6VF1C68nwsCBztxvXehChyB4UWSBySjua3sDy7ISw5ievXpxQLmv7aIDN8wAMkx5Efj1gX52RaTifLj1w4pQZJqli29lVmKCJBhEYBAEq4ug4Ikekan2+4i9EU1QIoApE9Awi24UxmerYtqpYU3er/+ge8ahFZ9YzkWIDbEHuwa5cUeOnCmVV2styA1zBSbL4HAQriDktGE8EDsTzADMm9tvQUg2ZszpzGMIMjij/bIR3TSkJgN0rLJuw+y6oj6rUN+glI1uK0oKFJjfK6uDx9kya2oSpOw7FLju+zc/ewAJQexXeEhun3d5fcHASFAMRdX9LUo/+e94bgPZPq7ikAGzTHqxQVMlhfJjaCgSfBxgiKzt65dDDJF5hMwKLvs8ooKrwbibsMoMp9lH4J05T3IzneKNQp7sLhagCLWJoDMjLcIpL6MTvSiCZloYh8I2Jq+BSDzFtd7BJKvrLohYY9+g8cngVHuVWRRgOSvHeBAFSUJPaLr1qXuSIAiSO4DGTMQjuhim3SfHGFVn0x89ouVL4EcZ4EQlSQNozckz94YsrC7cj/IJgRZFyCkE9Pg1ofY1vLkk+CZ1t0g+1gRIldEqCLSSR8sLw5/k2b9nSCHGIQDeV12jXN6kNWRFtuwe2R6L8g2V6Q2CsvLFl7++FdxOIci5ovxvjyyCEHE1RUkKcoVo0g9ed8vhe/0yHMKEl/orIuVZ1MLX4OEIn6eUapypyLHCgRJCs/TkUhVmVyC39OHmYtHdl9i59+KqvOJrSDrS1E/HgZ5y0AGQCpN5LcJi0uhRCScoHwV5L1QRF8tqGrhanHRgoSE2dXfQLkX5CMHMRdTswh6RMW8enND4ksgw6IGITFWMEFV79T1XLqDxBj+HwLI8LVq1XPgAAAAAElFTkSuQmCC'));
    }
}
