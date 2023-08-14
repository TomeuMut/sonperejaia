<div class="layout-row min-size panel-contents">
    <div class="control-toolbar toolbar-padded">
        <div class="toolbar-item" data-calculate-width>
            <div class="btn-group">
                <button type="button" class="btn btn-default oc-icon-plus last"
                    data-builder-command="databaseTable:cmdCreateTable"
                    ><?= e(trans('rainlab.builder::lang.common.add')) ?></button>
            </div>
        </div>
        <div class="relative toolbar-item loading-indicator-container size-input-text">
            <input
                type="text"
                name="search"
                value="<?= e($this->getSearchTerm()) ?>"
                class="form-control icon search" autocomplete="off"
                placeholder="<?= e(trans('rainlab.builder::lang.database.search')) ?>"
                data-track-input
                data-load-indicator
                data-load-indicator-opaque
                data-request="<?= $this->getEventHandler('onSearch') ?>"
            />
        </div>
    </div>
</div>