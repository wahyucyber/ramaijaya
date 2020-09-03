
<script>

    var token = uri_segment(2).split('&&')[0]
    
    class Reset {
        constructor(){
            
        }
        run()
        {
            var data = {
                token: token,
                password: $('input.password').val()
            }
            
            callApi('forgot/reset_password/',data,function(res){
                if(res.Error){
                    notif('.msg-content','danger',res.Message)
                }else{
                    session.set_flashdata('msg_success',res.Message)
                    redirect('login')
                }
            })
        }
    }
    
    var reset = new Reset
    
    $(document).on('submit','#form-forgot',function(e){
        e.preventDefault()
        
        reset.run()
        
    })
    
</script>