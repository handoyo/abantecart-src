<div class="product-dimensions product-dimensions-flex value">
	<div class="product-dimensions-item text-nowrap">
        <label class="mb0"><?php echo $data['length']->title; ?></label>
	</div>
    <div class="product-dimensions-item afield">
		<?php
        $data['length']->attr .= ' style="width: 100px;"';
        echo $data['length']; ?>
	</div>
    <b class="fa-2x">&Cross;</b>
	<div class="product-dimensions-item">
        <label class="mb0"><?php echo $data['width']->title; ?></label>
	</div>
    <div class="product-dimensions-item afield">
		<?php
        $data['width']->attr .= ' style="width: 100px;"';
        echo $data['width']; ?>
	</div>
    <b class="fa-2x">&Cross;</b>
	<div class="product-dimensions-item">
        <label class="mb0"><?php echo $data['height']->title; ?></label>
	</div>
	<div class="product-dimensions-item afield">
		<?php
        $data['height']->attr .= ' style="width: 100px;"';
        echo $data['height']; ?>
	</div>
	<div class="product-dimensions-item afield">
		<?php
        $data['length_class']->attr .= ' style="width: 200px;"';
        echo $data['length_class']; ?>
	</div>
</div>
