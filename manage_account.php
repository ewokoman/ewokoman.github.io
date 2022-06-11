<?php
require_once("DBConnection.php");
$qry = $conn->query("SELECT * FROM `user_list` where user_id = '{$_SESSION['user_id']}'");
    foreach($qry->fetch_array() as $k => $v){
        $$k = $v;
    }
?>
<div class="content py-3">
    <div class="card shadow rounded-0">
        <div class="card-body">
        <h3>Управление аккаунтом</h3>
            <hr>
            <div class="col-md-6">
                <form action="" id="user-form">
                    <input type="hidden" name="id" value="<?php echo isset($user_id) ? $user_id : '' ?>">
                    <div class="form-group">
                        <label for="fullname" class="control-label">Полное имя</label>
                        <input type="text" name="fullname" id="fullname" required class="form-control form-control-sm rounded-0" value="<?php echo isset($fullname) ? $fullname : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Логин</label>
                        <input type="text" name="username" id="username" required class="form-control form-control-sm rounded-0" value="<?php echo isset($username) ? $username : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Новый пароль</label>
                        <input type="password" name="password" id="password" class="form-control form-control-sm rounded-0" value="">
                    </div>
                    <div class="form-group">
                        <small>Оставьте поле «Новый пароль» пустым, если не хотите обновлять свой пароль.</small>
                    </div>
                    <div class="form-group">
                        <label for="old_password" class="control-label">Старый пароль</label>
                        <input type="password" name="old_password" id="old_password" class="form-control form-control-sm rounded-0" value="">
                    </div>
                    <div class="form-group d-flex w-100 justify-content-end">
                        <button class="btn btn-sm btn-primary rounded-0 my-1">Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#user-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./Actions.php?a=update_credentials',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                            location.reload()
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>