<table class="border-0">
    <tr>
        <td>
            <div class="input-group afield">
                <div class="input-group-addon"><?php echo $data['currency']['symbol_left']; ?></div>
                <?php echo $data['price']; ?>
                <div class="input-group-addon"><?php echo $data['currency']['symbol_right']; ?></div>
            </div>
        </td>
        <td>
            <b class="fa-2x ml10 mr10">&plus;</b>
        </td>
        <td>
            <div class="input-group">
                <div class="input-group-addon">
                    <?php echo $data['entry_tax_rule']; ?>
                </div>
                <?php echo $data['tax_selector']; ?>
            </div>
        </td>
        <td><b class="fa-2x ml10 mr10">&equals;</b></td>
        <td>
            <div class="input-group">
                <div class="input-group-addon"><?php echo $data['entry_price_with_tax']; ?></div>
                <div class="input-group-addon"><?php echo $data['currency']['symbol_left']; ?></div>
                <?php echo $data['price_with_tax']; ?>
                <div class="input-group-addon"><?php echo $data['currency']['symbol_right']; ?></div>
            </div>
        </td>
    </tr>
</table>

<script type="text/javascript">
    let priorElm;
    $(document).on(
        'change blur drop focus',
        'input[name="price"], input[name="price_with_tax"]',
        function (e) {
            priorElm = e.type === 'drop' ? $(this) : priorElm;
        }
    );
    $(document).on('change', 'select[name="tax_selector"]', onKUp);

    let timer;
    const waitTime = 500;

    $('input[name="price"]')[0].addEventListener('keyup', onKUp);
    $('input[name="price_with_tax"]')[0].addEventListener('keyup', onKUp);
    function onKUp(event){
        clearTimeout(timer);
        timer = setTimeout(() => {
            if($(event.target).attr('name')!=='tax_selector') {
                priorElm = $(event.target).change();
            }
            getTaxedPrice($(event.target));
        }, waitTime);
    }

    function getTaxedPrice(initiator, sendData = {}) {
        let priceElm = $('input[name="price"]');
        
        if (initiator.attr('name') === 'tax_selector') {
            initiator = priceElm;
        }
        let currentValue = initiator.val();
        currentValue = currentValue.replace(/[^0-9.]/g, '');
        currentValue = currentValue === '' || currentValue === null  ? '0.00' : currentValue;
        initiator.val(currentValue);

        sendData[initiator.attr('name')] = currentValue;
        sendData['tax_class_id'] = $('select[name="tax_selector"]').val();
        let urlParams = new URLSearchParams(sendData).toString();
        let value = urlParams ? '&' + urlParams : '';
        $.get(
            '<?php echo $data['price_calc_url']?>' + value,
            function (res) {
                // Parse JSON response if it's a string
                let data = typeof res === 'string' ? JSON.parse(res) : res;
                $.each(data, function (key, value) {
                    if ($('[name="' + key + '"]').length > 0) {
                        $('[name="' + key + '"]').val(value).aform().change();
                    }
                });
            }
        );
    }

    $(document).ready(function () {
        let price = $('input[name="price"]');
        let p = price.val();
        if (p !== '' && p !== '0.0' && p !== '0.00') {
            getTaxedPrice(price);
        }
    });
</script>
