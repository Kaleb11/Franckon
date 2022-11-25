<template>
 
		    <!-- #001B3B -->
           <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-5" style="">
             <div>
					<img :src="'https://i.pinimg.com/originals/2a/ff/5d/2aff5d3ae14a89142c768228c5c2d4ec.png'" style="
    width: 77px;
    height: 80px;
    margin-left: 156px;
">
         
            </div>
              <!-- <div class="login_header">
                   <h1 style="color:white">Login to Franckon</h1>
               </div>
               <div v-if="err" style="margin-left: 60px"><p style="color:red; font-weight:bold;">{{err}}</p></div>
                <div class="space">
                   <Input type="email" autocomplete="name" v-model="data.email" placeholder="Email" />
                </div>                     
                <div class="space">
                   <Input type="password" autocomplete="password" v-model="data.password" placeholder="******" />
                </div>
                <div class="login_footer"> -->
                     <!-- <Button type="primary" @click="login()" :disabled="isLogging" :loading="isLogging">{{isLogging ? 'Logging...' : 'Login'  }}</Button> -->
                     <!-- <Button type="primary" style="color:aliceblue; background: black; font-family: Trirong, serif;" v-if="loading" loading shape="circle">Logging...</Button>
                     <Button type="primary" style="color:aliceblue; background: black; font-family: Trirong, serif;" v-if="!loading" @click="login()">Login</Button>
                     
                </div>
              
            </div> -->
         
           <v-form
    ref="form"
    lazy-validation
    autocomplete="off"
   style="width: 415px;padding: 38px;"
  >
   
<div v-if="err" style="margin-left: 60px"><p style="color:red; font-weight:bold;">{{err}}</p></div>
                <div class="space"></div>
    <v-text-field
      v-model="data.email"
      :rules="emailRules"
      label="E-mail"
      name="input-10-1"
      outlined
      border-color="black"
      required
    ></v-text-field>

  
   <v-text-field
            outlined
            color="black"
            v-model="data.password"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.required, rules.min]"
            :type="show1 ? 'text' : 'password'"
            name="input-10-1"
            label="Password"
            hint="At least 8 characters"
            border-color="black"
            counter
            @click:append="show1 = !show1"
          ></v-text-field>

    

    <v-btn
      color="success"
      class="mr-4"
      @click="login()"
      :disabled="isLogging"
      style="
          margin-top: 20px;margin-left: 105px;
      "
      v-if="!loading" 
    >
      Login
    </v-btn>
<v-btn
  v-if="loading"
  elevation="2"
  loading
  color="success"
      class="mr-4"
      
      style="
          margin-top: 20px;margin-left: 105px;
      "
>Logging...</v-btn>
    
  </v-form>
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
          err : '',
          show1: false,
          show2: false,
          show3: false,
          show4: false,
          password: 'Password',
          rules: {
            required: value => !!value || 'Required.',
            min: v => v.length >= 8 || 'Min 8 characters',
            emailMatch: () => (`The email and password you entered don't match`),
          },
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
.v-text-field--outlined >>> fieldset {
  border-color: rgba(19, 18, 20, 0.986)}
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