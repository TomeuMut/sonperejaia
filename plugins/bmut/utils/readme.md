# Utilidades para October CMS

***

# Scripts de analytics y seo

Es necesario añadir dos placeholders en el layout/partials que nos interese

Antes de la etiqueta de cierre de **`<head>`** debemos añadir
```
    {% placeholder analytics %}
```

Justo después de la etiqueta **`<body>`** debemos añadir
```
    {% placeholder noscripts %}
```

# Generar recortes de imágenes con nombres validos para seo.

### Como funciona

A la hora de crear los attach en un modelo, hay que indicarle el nuevo modelo de File en lugar de `System\Models\File`

```php
public $attachOne = [
    'image' => [ 'Bmut\Utils\Classes\Helpers\File', 'delete' => true]
];
```

El método getPath devuelve el nombre que genera october para la imagen. Ese no se ha cambiado.
El método getThumb devolverá el nombre con el que se ha subido la imagen, pasado por el método `str_slug`.

***

# Urls para robots.

El archivo `routes.php` tiene definidas las rutas para subir archivos de robots en `storage\app\`.
El nombre del archivo debe ser **robots.txt**
Los archivos se suben desde `Seo>Settings>Seo`.

***

# Sitemap
El sitemap se genera desde el apartado de `Seo>Sitemap`

Por defecto se peuden crear todas las páginas estáticas, que no tienen parametros en la url.

Se elige el tema y la página que queremos añadir.
Luego seleccionamos el **Tipo**, por defecto solo hay un valor: **Cms**, que son las páginas estáticas.
Seleccionamos también la frecuencia de cambio y la prioridad.
Esto nos genera las urls de cada página seleccionada en todos los idiomas que tengamos activados.

Para las páginas dinámicas, por ejemplo de un blog, hay 2 eventos en el plugin para generar **tipos** y los **detalles** de las páginas.

El primero es el más sencillo, está en el modelo **`Bmut\Utils\models\Sitemap@getTypeOptions`**
Es el evento **`rw.sitemap.types`**
Este evento tiene que devolvernos un array de arrays con todos los tipos de página que queramos dar de alta por parte de ese plugin.

Lo único que necesitamos añadir en el el método `boot` del plugin es lo siguiente. Solo hay que devolver un array con los tipos de página que queremos dar de alta en este plugin. (Cada plugin debe devolver valores y nombres únicos)
```php
Event::listen('rw.sitemap.types', function () {
    return [
        'pages' => 'Páginas',
        'otras' => 'Otras Páginas'
    ];
});
```
Esto hará que aparezcan listados en el selector de tipos.

El otro evento es el que devuelve todas las urls con los detalles necesarios para añadirlas al sitemap.
Es el evento `rw.sitemap.generate`

Esto sería el código de ejemplo para añadir páginas al sitemap de un plugin que tiene un modelo **Page**, con páginas dinámicas con un campo **slug**

```php
use System\Classes\PluginManager;
use Cms\Classes\Page as CmsPage;
use Cms\Classes\Theme;
use Event;
use October\Rain\Router\Router as RainRouter;
use RainLab\Translate\Models\Locale;
use RainLab\Translate\Classes\Translator;
use RW\Paginas\Models\Page;
use Url;

    public function boot()
    {
        Event::listen('rw.sitemap.types', function () {
            return [
                'pages' => 'Páginas',
                'otras' => 'Otras Páginas'
            ];
        });

        Event::listen('rw.sitemap.generate', function ($item, $theme) {
            //Si no es del tipo que hemos dado de alta, en este caso 'pages', no tenemos que hacer con ese item.
            if ($item->type !== 'pages') {
                return;
            }
            $sitemaps = collect();
            $plugins = PluginManager::instance();
            //Obtenemos todas las entradas
            $pages = Page::isActive()->get();

            //Si tenemos instalado y activo Rainlab.Translate tenemos que generar urls en todos los idiomas
            if ($plugins->exists('RainLab.Translate') &&
                !$plugins->isDisabled('RainLab.Translate')) {

                $locales = Locale::listEnabled();
                $cmsPage = CmsPage::load($theme, $item->page.'.htm');

                foreach ($pages as $page) {
                    foreach (array_keys($locales) as $locale) {
                        $sitemap = new \stdClass;
                        $sitemap->lastMod = date('c'); //Se podría poner si tuviese el updated-at, etc.
                        $sitemap->changeFreq = 'always';
                        $sitemap->priority = '0.5';
                        $sitemap->url = $sitemap->url ?? $this->getItemUrlLocale($cmsPage, $page, $locale);
                        $sitemap->alternates = $this->getItemAlternates($cmsPage, $page, $locales);
                        $sitemaps->push($sitemap);
                    }
                }
                return $sitemaps;
            }
            //Si no está en idiomas
            foreach ($pages as $page) {
                $sitemap = new \stdClass();
                $sitemap->lastMod = date('c'); //Se podría poner si tuviese el updated-at, etc.
                $sitemap->changeFreq = $item->changefreq ?? 'always';
                $sitemap->priority = $item->priority ?? '0.5';
                $sitemap->url = $this->getItemUrl($item, $page);
                $sitemaps->push($sitemap);
            }
            return $sitemaps;
        });
    }

    /**
     * Get the url when there is no translations
     * @param  object $item sitemap model
     * @param  object $page page model with slug
     * @return string url
     */
    private function getItemUrl($item, $page)
    {
        /*Este parámetro pageslug es el que hemos dado de alta en el archivo de la página de october  :pageslug */
        /* $page->slug es el campo por el que se busca el modelo. */
        $params = ['pageslug' => $page->slug];
        $url = CmsPage::url($item->page, $params);
        return $url;
    }

    /**
     * Get the urls in all the active locales
     * @param  object $cmsPage october cms page (CmsPage::load($theme, $item->page.'.htm')
     * @param  object $page page model with slug
     * @param  array $locales list of october active locales (Locale::listEnabled())
     * @return array with url in each locale and locale code
     */
    private function getItemAlternates($cmsPage, $page, $locales)
    {
        $alternates = [];
        foreach (array_keys($locales) as $locale) {
            $alternate = [];
            $alternate['locale'] = $locale;
            $alternate['url'] = $this->getItemUrlLocale($cmsPage, $page, $locale);
            $alternates[] = $alternate;
        }
        return $alternates;
    }

    /**
     * Get the url in a given locale
     * @param  object $cmsPage october cms page (CmsPage::load($theme, $item->page.'.htm')
     * @param  object $page page model with slug
     * @param  string $locale
     * @return string url in locale
     */
    private function getItemUrlLocale($cmsPage, $page, $locale)
    {
        $translator = Translator::instance();
        $page->translateContext($locale);
        /*Este parámetro pageslug es el que hemos dado de alta en el archivo de la página de october  :pageslug */
        /* $page->slug es el campo por el que se busca el modelo. */
        $params = ['pageslug' => $page->slug];
        $router = new RainRouter;
        $cmsPage->rewriteTranslatablePageUrl($locale);
        $localeUrl = $router->urlFromPattern($cmsPage->url, $params);
        $url = Url::to('/') . '/' . $translator->getPathInLocale($localeUrl, $locale);
        return $url;
    }
```
Tiene que devolver un array o collection con todas las entradas que se han dado de alta para ese modelo.
Cada entrada es un objecto con las propiedades:
    - url. Un string con la url
    - alternates. Un array de arrays con una entrada por cada idioma, que tenga la propiedad **url** con la url, y **locale** con el código de idioma.
    - lastMod. Una fecha como date('c'), si hubiese un campo updated_at o similar, se podría utilizar.
    - changeFreq. Un string con uno de los siguientes valores: always, hourly, daily, weekly, monthly, yearly, never;
    - priority. Un número entre 0.1 y 1.

***

# Scope Activatable

Para no tener que estar escribiendo un scope para filtrar los elementos que están activos, este behavior está basado en el "Sortable" de October.

Añadiendo esta linea en el boot() de un plugin.
```php
    Product::extend(function ($model) {
       $model->extendClassWith(ActivatableModel::class);
    });
```

Por defecto buscará en el modelo el campo `is_active` con valor `1`

Se puede sobreescribir el campo y valor a buscar añadiendo en el modelo las variables:
```php
    public $activeColumn = 'nombre_del_campo';
    public $activeValue = 'valor_activo';
```

Además si añadimos el Behavior al controlador aparecerá un filtro tipo switch para mostrar los registros activos, inactivos o todos.

En el método boot() de un plugin:
```php
    Products::extend(function ($controller) {
        $controller->extendClassWith(ActivatableController::class);
    });
```

# Scope Expirable

En ocasiones queremos que un modelo sea visible hasta X fecha y hora, con el behavior Expirable podemos añadir esta funcionalidad. Para ello se añadirá el behavior desde el boot() de un plugin

Añadiendo esta linea al modelo que queramos. Solo está activo en el frontend, en el backend no se filtra con este Trait.
Por defecto buscará en el modelo el campo `expires_at` y se comparará con la fecha y hora actual del servidor( Carbon::now() )
```php
    Product::extend(function ($model) {
        $model->extendClassWith(ExpirableModel::class);
    });
```
Además podemos añadir un filtro al controlador con el behavior.
```php
    Products::extend(function ($controller) {
        $controller->extendClassWith(ExpirableController::class);
    });
```

***

# Seo

Lista las páginas que tenemos creadas en el tema y les podemos poner titulos y descripciones.


## Seo para páginas dinámicas

Para añadir campo de seo para cualquier página dinámica, como por ejemplo un blog, hay que añadir un Behavior al modelo en el boot() de cualquier plugin
```php
    Post::extend(function ($model) {
        $model->extendClassWith(SeoExtendableModel::class);
    });
```
Y en el controlador del modelo hay que añadir otro Behavior:

```php
    Posts::extend(function ($controller) {
        $controller->extendClassWith(SeoExtendableController::class);
    });
```
**_Ojo, si ponemos el Behavior directamente en el implements del controlador, tiene que estar antes que el de RelationController._**


Con esto nos aparecerá un formulario para añadir campos de seo a la página en el contexto "Update" y "Preview".

Otra opción es aprovechar el placeholder `bmutSeo` y añadir los metas que queramos

Ejemplo de metas para una página dinámica
```
    {% put bmutSeo %}
        <title>Título</title>
        <meta name="description" content="Descripción"/>
        <meta name="title" content="Título meta"/>
        <meta name="keywords" content="keyword,otrakey"/>
        <meta property="og:title" content="tituloog"/>
        <meta property="og:description" content="descripcion og"/>
        <meta property="og:image" content="imagenog"/>
    {% endput %}
```

***

# HrefLang

En el plugin de translate de rainlab ya hay un componente que se encarga de hacerlo.

## Detección del idioma del navegador
Hay que meter el componente LanguageDetector en el layout, además hay que comentar la linea del middleware de Rainlab.Translate LocaleMiddleware, la linea 25
```php
    // $translator->setLocale($translator->getDefaultLocale());
```
Esta linea fuerza el idioma por defecto en el translate haciendo que el componente no pueda detectar el idioma del navegador.

##  Forzar redirección https
Para que las peticiones vayan por https hay que poner el "LINK_POLICY" desde el .env o config/cms.php con el valor 'secure'
```dotenv
LINK_POLICY=secure
```

## Validar traducciones de los modelos
Si se usa validación en las traducciónes es necesario incluir el trait TranslateFixes, ya que Rainlab.Translate no hace las validaciones.

Además de validar también hace que cuando se borre un registro se borren las traducciones asociadas a él, incluidas las traducciones de index => true.
***

# Sortable Relations
Gestiona el orden de la relación entre dos modelos directamente en el listado del widget de la relación entre estos dos; con una funcionalidad de drag and drop. Ejemplos con `Category` y `Product`.
## Base
En todos los casos se deberán añadir dos cosas en el controlador: el implement y especificar el archivo de configuración.
Tal que así:
```php
class Categories extends Controller
{
    public $implement = [
        ...
        'Bmut\Utils\Behaviors\SortableRelationsController',
    ];

    public $sortableRelationsConfig = 'config_sortable_relations.yaml';
    ...
```
El archivo de configuración se debe crear en el directorio del controlador (`/controllers/categories/config_sortable_relations.yaml`) como los demás yaml.
Con el contenido del ejemplo siguiente:
```yaml
parentClass: Autor\Plugin\Models\Category

products: # nombre de la relación
    modelClass: Autor\Plugin\Models\Product
    pivot: true|false # true para N-M, false para 1-N
```
## Caso Relación 1-N
En el modelo hijo se ha de añadir el trait Sortable propio de october:
```php
class Product extends Model
{
    use \October\Rain\Database\Traits\Sortable;

    const SORT_ORDER = 'custom_sort_order'; // NO obligatorio. Indica el nombre a usar para el campo de orden
    ...
```
## Caso Relación N-M
El campo orden estará dentro de la tabla pivot. Debemos añadir el trait SortableRelations en el modelo padre y la variable que indica que campo de la tabla pivot se ha de mirar:
```php
class Category extends Model
{
    use \Bmut\Utils\Classes\Traits\SortableRelations;

    // ejemplo relación N-M
    public $belongsToMany = [
        'products' => [
            'Autor\PLugin\Models\Product',
            'table' => 'autor_plugin_category_product',
            'pivot' => ['custom_sort_order']
        ]
    ];

    public $pivotSortableRelations = [
        'products' => 'custom_sort_order'
    ];
    ...
```

## Timers
Una clase para comprobar el rendimiento del código.
Nos creará un header en la respuesta del servidor, con datos de rendimiento con las etiquetas que queramos.
Nos puede server para ver cuanto está tardando una query, generar documentos, etc.
Así podemos aislar la parte que más se puede optimizar.
Para ver la respuesta, en el DevTools de Chrome -> Network -> Pinchamos sobre la petición que queramos, y nos vamos a la pestaña Timing de los detalles que nos aparecen, ahí aparecerán los detalles de las peticiones con las etiquetas que le hemos puesto. En formato de gráfico de barras.

En el resto de navegadores podemos ver el header en el apartado de headers de la petición, tiene los mismos datos, pero no es tan bonito.

Esto nos puede ahorrar ir haciendo exits y demás.

El debugbar también puede servir para esto, pero esta clase es mucho más sencilla.
Se podría intentar integrar este paquete también
https://github.com/tuupola/server-timing-middleware

```php
$timer = new PerformanceTimer();

$timer->startTimer('db');
usleep('200000');
$timer->endTimer('db');

$timer->startTimer('tpl', 'Templating');
usleep('300000');
$timer->endTimer('tpl');

$timer->startTimer('geo', 'Geocoding');
usleep('400000');
$timer->endTimer('geo');

header('Server-Timing: '.$timer->getTimers());
```

# Como instalar
A partir de la versión 2 de October, los plugins se instalan desde consola de comandos:

Primero agregar el repositorio de composer privado que tenemos alojado en gitlab:
```shell
composer config repositories.plugins-gitlab composer https://gitlab.com/api/v4/group/4331803/-/packages/composer/packages.json
```

Ejecutar `composer require bmut/utils`

Ejecutar `php artisan october:migrate`


Si da un error de publickey en windows y teneis passphrase puesto ejecutad esto:
```shell
start-ssh-agent
```

