<div class="product-dimensions product-dimensions-flex value">
	<div class="product-dimensions-item text-nowrap">
		<?php echo $data['length']->title; ?>
	</div>
    <div class="product-dimensions-item afield">
		<?php
        $data['length']->attr .= ' style="width: 100px;"';
        echo $data['length']; ?>
	</div>
    <b class="fa-2x">&Cross;</b>
	<div class="product-dimensions-item">
		<?php echo $data['width']->title; ?>
	</div>
    <div class="product-dimensions-item afield">
		<?php
        $data['width']->attr .= ' style="width: 100px;"';
        echo $data['width']; ?>
	</div>
    <b class="fa-2x">&Cross;</b>
	<div class="product-dimensions-item">
		<?php echo $data['height']->title; ?>
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
