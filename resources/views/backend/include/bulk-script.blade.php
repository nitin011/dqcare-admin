<script>
    
    var bulk_ids = [];
    
    $('.delete_Checkbox').on('change',function () {  
        if($(this).prop("checked") == true){
            var id = $(this).val();
            bulk_ids.push(id);
            $('#bulk_ids').val(bulk_ids);
        }
        else if($(this).prop("checked") == false){
            var id = $(this).val();
            bulk_ids.pop(id);
            $('#bulk_ids').val(bulk_ids);
        }
    });
    $(document).on('click', '.confirm-action', function (e) {
        e.preventDefault();
        var action = '<input type="hidden" name="action" value="'+$(this).val()+'">';
        let form = $(this).closest('form');
        form.append(action);
        var url = $(this).attr('href');
        let message = $(this).data('message');
        let title = $(this).data('title');

        $.confirm({
            draggable: true,
            title: title ?? 'Are You Sure!',
            content: message ?? "You won't be able to revert back!",
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-red',
                    action: function(){
                        if(form != null){
                            form.submit();
                        } else {
                            window.location.href = url;
                        }
                    }
                },
                close: function () {
                }
            }
        });
    });

    String.prototype.rtrim = function() {
        return this.replace(/\s+$/,"");
    }

    $(document).on('click','.allChecked',function(){
        if($(this).prop("checked") == true){
            var deleteRecord = '';
            $('.delete_Checkbox').prop('checked',true);
            $('.delete_Checkbox').each(function(){
                var rec = $(this).val();
                deleteRecord += rec+',';
                
            });
            $('#bulk_ids').val(deleteRecord.rtrim(','));
        }else{
            $('.delete_Checkbox').prop('checked',false);
        }
    });

</script>