<template>
   <div class="container">
		    
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-5" style="background-color: #001B3B">
             
               <div class="login_header">
                   <h1 style="color:white">Login to the Franckon</h1>
               </div>
               <div v-if="err" style="margin-left: 60px"><p style="color:red; font-weight:bold;">{{err}}</p></div>
                <div class="space">
                   <Input type="email" autocomplete="name" v-model="data.email" placeholder="Email" />
                </div>                     
                <div class="space">
                   <Input type="password" autocomplete="password" v-model="data.password" placeholder="******" />
                </div>
                <div class="login_footer">
                     <!-- <Button type="primary" @click="login()" :disabled="isLogging" :loading="isLogging">{{isLogging ? 'Logging...' : 'Login'  }}</Button> -->
                     <Button type="primary" style="color:aliceblue; background: black;" v-if="loading" loading shape="circle">Logging...</Button>
                     <Button type="primary" style="color:aliceblue; background: black;" v-if="!loading" @click="login()">Login</Button>
                     
                </div>
              
            </div>
            </div>
</template>
<script>
export default {
    data(){
        return {
          data :{
              email:'',
              password:'',
          },
          loading:false,
          err : ''
        }
      
    },
    methods :{
       async login(){
          if(this.data.email.trim()=='' || this.data.email== '') return this.error('Email is required')
          if(this.data.password.trim()=='' || this.data.password == '') return this.error('Password is required')
          if(this.data.password.length < 6) return this.error('Incorrect login details')
          this.loading = true
          const res = await this.callApi('post','app/admin_login',this.data)
          if(res.status===200){
            //   this.success(res.data.msg)
            
              localStorage.setItem('storedData', JSON.stringify(res.data.user));
              window.location='/projects'
          }else{
              this.err = 'Incorrect login details!'
              if(res.status===401){
                  this.warning(res.data.msg)
              }else if(res.status===422){
                  for(let i in res.data.errors){
                    this.error(res.data.errors[i])
                }
              }else{
                  this.swr()
              }
          }
          this.loading = false
       }
       },
}
</script>
<style scoped>
   ._1adminOverveiw_table_recent {
       margin: 0 auto;
       margin-top:175px;
       width:fit-content;
   }
   .login_footer{
       text-align: center;
       margin-top:12px;
   }
   .login_header{
       text-align: center;
       padding:12px;
   }
</style>