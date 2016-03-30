<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <? echo $this->element('x_title') ?>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="api/test">
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            Environment/Server
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <span class="label label-info"><?php echo SYSTEM_ENVIRONMENT; ?></span>
                            <span class="label label-info"><?php echo SERVER_NAME; ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_method">
                            Method
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="api_method" id="api-method-id">
                                <?php foreach($api_methods as $api_method){ ?>
                                <option value="<?php echo $api_method ?>" <?php echo ($api==$api_method)?'selected':''; ?> ><?php echo $api_method ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="access_time">
                            access_time
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="span5 form-control" name="access_time" value="<?php echo isset($access_time)?$access_time:''; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="udid">
                            udid
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="span5 form-control" name="udid" value="<?php echo isset($udid)?$udid:''; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="auid">
                            auid
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="span5 form-control" name="auid" value="<?php echo isset($auid)?$auid:''; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="access_key">
                            access_key
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="span5 form-control" name="access_key" value="<?php echo isset($access_key)?$access_key:''; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">client_query</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <button id="more_param" class="btn btn-primary btn-mini" type="button"><i class="fa fa-plus-sign fa-white"></i>Param</button>
                            <table class="table table-striped" id="paramTable">
                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>Param</th>
                                        <th>Value</th>
                                    </tr>

                                </thead>
                                <tbody id="params-body">
                                    <?php if (!empty($client_query_arr)){ ?>
                                    <?php foreach($client_query_arr as $param => $value){ ?>
                                    <tr>
                                        <td>-</td>
                                        <td><input type="text" name="params[]" class="form-control" placeholder="Param" value="<?php echo $param;?>"></td>
                                        <td><input type="text" name="values[]" class="form-control" placeholder="Value" value="<?php echo $value;?>"></td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12 text-center">
                        <input type="submit" style="margin-left: 180px;" id="invoke" class="btn btn-primary" name="invoke" value="Send">                    
                    </div>
                </form>

                <?php if(isset($api_call_result)){ ?>
                <div><span class="label label-success">API URL:</span></div>
                <div class="well">
                    <p class="text-warning"><a href="<?php echo $api_url; ?>" target="_blank"><?php echo $api_url; ?></a></p>
                </div>

                <div><span class="label label-success">Result:</span></div>
                <div class="well">
                    <p class="text-warning"><?php echo $api_call_result; ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#more_param').click(function () {
            var new_row_html = '<tr><td>[-]</td><td><input class="form-control" type="text" name="params[]" placeholder="Param"></td>\n\
                                <td><input class="form-control" type="text" name="values[]" placeholder="Value"></td></tr>';
            if ($('#paramTable tr:last') != null) {
                $('#paramTable tr:last').after(new_row_html);
            } else {
                $('#paramTable tbody').html(new_row_html);
            }
        });
        $("#api-method-id").change(function () {
            var value = $("#api-method-id").val();
            $.ajax({
                dataType: "json",
                type: "POST",
                url: 'api/load_param_json/' + value,
            }).done(function (data) {
                data_Arr = data;
                var line = '';
                console.log(data);
                $("#params-body").empty();
                console.log(data);
                $.each(data, function (key, value) {
                    var new_row_html = '<tr><td>[-]</td><td><input class="form-control" type="text" name="params[]" value="'+ key +'"></td>\n\
                                <td><input class="form-control" type="text" name="values[]" value="'+value+'"></td></tr>';
                    $("#params-body").append(new_row_html);
                });
                
            }).fail(function (jqXHR, textStatus) {
                console.log('fail');
            });
        });
    });
</script>