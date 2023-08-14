<?php namespace Bmut\Utils\Classes\Traits;

trait SortableRelations
{
    /**
     * Boot the SortableRelations trait for this model.
     *
     * @return void
     */
    public static function bootSortableRelations()
    {
        static::extend(function ($model) {
            $model->duplicateSortableRelationsWithDefaultOrder();

            $model->bindEvent('model.relation.attach', function ($relationName, $attachedIdList, $insertData) use ($model) {
                if ($pivotSortableColumn = $model->getPivotSortableColumn($relationName)) {
                    $nextSortOrder = $model->{$relationName}()->count();

                    foreach ((array) $attachedIdList as $attachedId) {
                        $model->updatePivotOrder($attachedId, $relationName, $pivotSortableColumn, $nextSortOrder);
                        $nextSortOrder++;
                    }

                    $model->reloadRelations($relationName);
                }
            });

            $model->bindEvent('model.relation.detach', function ($relationName, $attachedIdList) use ($model) {
                if ($pivotSortableColumn = $model->getPivotSortableColumn($relationName)) {
                    $relatedModels = $model->{$relationName};

                    foreach ($relatedModels as $i => $relatedModel) {
                        $relatedModel->pivot->{$pivotSortableColumn} = ($i + 1);
                        $relatedModel->pivot->save();
                    }

                    $model->reloadRelations($relationName);
                }
            });
        });
    }

    public function setSortablePivotOrder($relationName, $sortableIds, $sortableOrders = null)
    {
        $pivotSortableColumn = $this->getPivotSortableColumn($relationName);

        foreach ($sortableIds as $index => $id) {
            $this->updatePivotOrder($id, $relationName, $pivotSortableColumn, $sortableOrders[$index]);
        }

        $this->reloadRelations($relationName);
    }

    protected function duplicateSortableRelationsWithDefaultOrder()
    {
        foreach ($this->pivotSortableRelations as $relationName => $pivotSortableColumn) {
            if (isset($this->belongsToMany[$relationName])) {
                $relation = $this->belongsToMany[$relationName];
                $relation['relation_order'] = $relation['table'] . '.' . $pivotSortableColumn;
                $this->belongsToMany[$relationName . 'Ordered'] = $relation;
            }
        }
    }

    protected function updatePivotOrder($relatedId, $relation, $pivotSortableColumn, $sortOrder)
    {
        $this->{$relation}()->updateExistingPivot($relatedId, [$pivotSortableColumn => $sortOrder]);
    }

    protected function getPivotSortableColumn($relationName)
    {
        return $this->pivotSortableRelations[$relationName] ?? null;
    }
}
