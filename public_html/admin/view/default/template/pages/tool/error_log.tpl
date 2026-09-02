<?php
include($tpl_common_dir . 'action_confirm.tpl');
?>
<div class="tab-content">
    <div class="panel-heading">
        <div class="primary_content_actions pull-left">
            <?php
            if ($download_btn) { ?>
                <div class="input-group-prepend">
                    <?php
                    $download_btn->style = 'btn btn-info';
                    $download_btn->icon = 'fa fa-download';
                    echo $download_btn;
                    ?>
                </div>
                &nbsp;
                <?php 
            } ?>
                <div class="btn-group">
                    <?php 
                    $log_list->attr .= ' style="min-width: 400px;"';
                    echo $log_list; ?>
                </div>
            <?php
            if ($clear_btn) { ?>
                <div class="btn-group">
                    <?php 
                    $clear_btn->style = 'btn btn-danger';
                    $clear_btn->icon = 'fa fa-trash';
                    echo $clear_btn;?>
                </div>
            <?php
            } ?>
        </div>
    </div>

    <div class="panel-body panel-body-nopadding">
        <div class="error-log">
            <?php
            if ($log) { ?>
                <table class="table table-striped">
                    <?php
                    foreach ($log as $line) { ?>
                        <tr>
                            <td><?php
                                echo nl2br($line); ?></td>
                        </tr>
                    <?php
                    } ?>
                </table>
            <?php
            } else { ?>
                <div class="text-center">
                    <h1><i class="fa fa-thumbs-o-up fa-lg"></i></h1>
                </div>
            <?php
            } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('select#filename').on('change', function () {
        location = '<?php echo $main_url; ?>&filename=' + $(this).val();
    });

    $('#download').on('click', function (e) {
        e.preventDefault();
        const filename = $('select#filename').val();
        if (filename) {
            location = '<?php echo $download_url; ?>&filename=' + filename;
        } else {
            warning_alert('Please select a file to download');
        }
    });
</script>
