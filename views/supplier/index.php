<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
?>
<div class="supplier">
    <?= $grid ?>
    <p class="selected-page-all">
        <span><b>All</b> <b id="suppliers-selected-number">0</b> conversations on this page have been selected.</span>
        <a href="javascript:;" class="to-select-search">Select all conversations that match this search</a>
    </p>
    <p class="selected-search-all">
        <span>All conversations in this search have been selected.</span>
        <a href="javascript:;" class="clear-selected-search">Clear selection</a>
    </p>
    <input type="hidden" name="is_all" id="suppliers-are-selected-all" value="0" form="supplier-export-form" />
</div>

<?php
Modal::begin([
    'id' => 'exportModal',
    'title' => 'Export to CSV',
    'toggleButton' => [
        'label' => 'Export',
        'class' => 'btn btn-warning',
    ],
    'footer' => '<button type="button" class="btn btn-primary download-button">Download CSV</button>',
]);
ActiveForm::begin([
    'id' => 'supplier-export-form',
    'action' => "#export",
]);
?>
<p>Choose column(s) to be included in the CSV :</p>
<input type="hidden" name="export" value="1" />
<input type="hidden" name="rows_str" value="" />
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="columns[]" value="id" disabled checked />
    ID
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="columns[]" value="name" />
    Name
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="columns[]" value="code" />
    Code
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="columns[]" value="t_status" />
    T Status
  </label>
</div>
<?php
ActiveForm::end();
Modal::end();
?>