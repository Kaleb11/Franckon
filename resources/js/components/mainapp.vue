<template>
 <v-app>
  <v-app-bar
      v-show="!$store.state.user"
      height="63px"
      color="#001B3B"
      dense
      dark
      fixed
    >
      

      <v-toolbar-title style="color:wheat; font-family: Trirong, serif;">FRANCKON ENGINEERING</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-menu
        left
        bottom
      >

        <v-list class="list-title">
        
        </v-list>
      </v-menu>
    </v-app-bar>
    <v-card class="overflow-hidden" v-if="$store.state.user" style="
    height: 55px;">
    <!-- color="#459c98" -->
    <!-- color="rgb(31 229 101)" -->
   
    <v-app-bar
      height="63px"
      color="#001B3B"
      dense
      dark
      fixed
    >
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title style="color: wheat; font-family: Trirong, serif;">FRANCKON ENG.</v-toolbar-title>

      <v-spacer></v-spacer>
<!-- <vuetify-audio :file="rr.soundurl" autoPlay=true flat=true ></vuetify-audio> -->



      



<v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on, attrs }">
         <v-btn 
         v-if="$store.state.user.role_id != 3 && $store.state.user.role_id != 2 && $store.state.user.role_id != 5"
         icon
         v-bind="attrs"
         v-on="on"
         @click="updateNotification"
         >
       
        <v-badge
        :content="notifications.length"
        :value="notifications.length"
        color="red"
        overlap
      >
      
        <v-icon>
         mdi-bell
        </v-icon>
      </v-badge>


      <!-- <v-badge
        v-if="$store.state.user.role_id == 4"
        :content="notificationtwo.length"
        :value="notificationtwo.length"
        color="red"
        overlap
      >
      
        <v-icon>
         mdi-bell
        </v-icon>
      </v-badge> -->
        <!-- <v-icon>mdi-bell</v-icon> -->
      </v-btn>
    <v-btn
         v-if="$store.state.user.role_id == 3 || $store.state.user.role_id == 2 || $store.state.user.role_id == 5"
         icon
         v-bind="attrs"
         v-on="on"
         @click="updateNotificationRole"
         >
       
        <v-badge
        :content="roleNotifications.length"
        :value="roleNotifications.length"
        color="red"
        overlap
      >
      
        <v-icon>
         mdi-bell
        </v-icon>
      </v-badge>


      <!-- <v-badge
        v-if="$store.state.user.role_id == 4"
        :content="notificationtwo.length"
        :value="notificationtwo.length"
        color="red"
        overlap
      >
      
        <v-icon>
         mdi-bell
        </v-icon>
      </v-badge> -->
        <!-- <v-icon>mdi-bell</v-icon> -->
      </v-btn>

        </template>



        <v-list
          dense
          elevation="1" 
          style="margin-top:30px;max-height: 500px"
          class="overflow-y-auto" >
          <v-list-item-group >
          <div v-for="(item, index) in notificationData" :key="item.id" v-if="$store.state.user.id == item.toUserId">
        
          <v-list-item>
            
            <template>
              <v-list-item-content @click="routeProject(item,index)">
                <!-- <v-list-item-title v-text="item.title"></v-list-item-title> -->

                <v-list-item-subtitle
                  class="text--primary"
                  v-text="item.message"
                ></v-list-item-subtitle>

                <v-list-item-subtitle><span>{{ item.created_at | moment("from","now",true) }} ago</span></v-list-item-subtitle>
              </v-list-item-content>

            
            </template>
          </v-list-item>
          <v-divider></v-divider>
        </div>
           


          <div v-if="$store.state.user.role_id != 1">
          <div v-for="(item, index) in roleNotificationsData" :key="item.id" v-if="$store.state.user.role_id == item.role_id">
        
          <v-list-item>
            
            <template>
              <v-list-item-content @click="routeProject(item,index)">
                <v-list-item-title v-text="item.title"></v-list-item-title>

                <v-list-item-subtitle
                  class="text--primary"
                  v-text="item.message"
                ></v-list-item-subtitle>

                <v-list-item-subtitle><span>{{ item.created_at | moment("from","now",true) }} ago</span></v-list-item-subtitle>
              </v-list-item-content>

            
            </template>
          </v-list-item>

          <v-divider></v-divider>
          </div>
          </div>
          </v-list-item-group>
          
        </v-list>
      </v-menu>














      <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
          >
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list class="list-title">
           <!-- <v-list-item 
            v-for="n in 5"
            :key="n"
            @click="() => {}"
          >
            <v-list-item-title>Option {{ n }}</v-list-item-title>
          </v-list-item> -->
          <v-list-item style="color:black; font-family: Trirong, serif;">
            <v-list-item-title style="color:black; font-family: Trirong, serif;"><v-icon class="mx-2">mdi-account</v-icon>Profile</v-list-item-title>
          </v-list-item>
          <v-list-item href="/logout" @click="logout">
            <v-list-item-title style="color:black; font-family: Trirong, serif;"><v-icon class="mx-2">logout</v-icon>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  
    <v-navigation-drawer
    
    app
    class="Sr"
    style="
    height:  1191%;
    background: linear-gradient(
        45deg,
        rgba(29, 236, 197, 0.5),
        rgba(91, 14, 214, 0.5) 100%
      );"
   
      v-model="drawer"
      :mini-variant.sync="mini"
      permanent
    >
      <v-list-item class="px-2" style="height: 63px;
      color: white;">
        <!-- <v-list-item-avatar>
          <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
        </v-list-item-avatar> -->

      <v-list-item-title v-for="(rle,i) in roles" :key="i" style="color: white; font-family: Trirong, serif;" v-if="user.role_id == rle.id"><b>FRANCKON ENGINEERING</b></v-list-item-title>
        <v-btn style="color: white;background-color: #001B3B;"
          icon
          @click.stop="mini = !mini"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
       
      </v-list-item>

      <v-divider style="border-color: wheat;"></v-divider>

      <v-list dense style="color: blue;">
        <v-list-item class="px-2">
        <v-list-item-avatar  style="margin-left: 76px;height: 80px;min-width: 80px;width: 80px;"  >
          <v-img :src="`${user.photo}`" data-holder-rendered="true"></v-img>
        </v-list-item-avatar>

        

        
      </v-list-item>
      <v-list-item-title style="text-align: center; color: white; font-family: Trirong, serif;" class="mx-2" v-for="(rle,i) in roles" :key="i" v-if="user.role_id == rle.id"><b>{{user.fullName}}({{rle.roleName}})</b></v-list-item-title>
        <div style="padding: 13px;"></div>
        <v-divider style="border-color: wheat;"></v-divider>
        <div style="padding: 5px;"></div>
        <v-list-item two-line v-for="menuItem in permission" :key="menuItem.resourceName" v-if="permission.length && menuItem.read && menuItem.resourceName != 'Inventory data'" link :to="'/'+menuItem.name">
              
               
                  <v-list-item-icon style="margin-left:-13px; color:white"><v-icon class="mx-1" style="color:white;" v-for="iconItem in icons" :key="iconItem.iconName" v-if="iconItem.routerName == menuItem.name"  >{{iconItem.iconName}}</v-icon> </v-list-item-icon>

               
                  <v-list-item-content style="margin-top: -8%; margin-left: -21px; color:white; font-family: Trirong, serif;"><v-list-item-title>{{menuItem.resourceName}}</v-list-item-title>
          </v-list-item-content>
         
        </v-list-item>

          <v-list-item style="color:white; font-family: Trirong, serif;" two-line href="/logout" @click="logout">
            
            <v-list-item-icon style="margin-left:-13px; font-family: Trirong, serif;">
              
              <v-icon style="color:white;" class="mx-1">logout</v-icon>
            </v-list-item-icon>
    
            <v-list-item-content style="margin-top: -8%; margin-left:-21px;"
            ><v-list-item-title>Logout</v-list-item-title>
             
          </v-list-item-content>    
           

          </v-list-item>
      </v-list>
     </v-navigation-drawer>
     <v-sheet
      id="scrolling-techniques-7"
      class="overflow-y-auto"
      max-height="600"
    >
      <v-container style="height: 1500px;">
      </v-container>
    </v-sheet>
     </v-card>
  
     
 
  
  
  
       <v-main>
      
        <router-view></router-view>
      
    </v-main>
</v-app>
    <!-- <div v-if="$store.state.user">
       -->
      <!--========== ADMIN SIDE MENU one ========-->
    
      <!--========== ADMIN SIDE MENU ========-->

      <!--========= HEADER ==========-->
      <!-- <div class="header">
        <div class="_2menu _box_shadow"> -->
          <!-- <div class="_2menu_logo"> -->
            <!-- <ul class="open_button">
              <li>
                <Icon type="ios-list" />
              </li>
              
            </ul> -->
            <!--<li><Icon type="ios-albums" /></li>-->
          <!-- </div> -->
        <!-- </div>
      </div> -->
      <!--========= HEADER ==========-->
    <!-- </div>
    	<router-view />
  </div> -->
 
</template>


<script>
import useSound from 'vue-use-sound';
import { mapGetters } from 'vuex';
export default{
  
    
    
  
  props: ['user','permission'],
  
  data(){
    return{
      isLoggedIn : false,
      roles:[],
      notifications:[],
      roleNotifications:[],
      roleNotificationsData:[],
      notificationtwo:[],
      notificationData:[],
      showMenu: true,
      mm:'',
      rr : { soundurl : '/uploads/Notif.mp3'} ,
      icons : [
				{iconName: 'dashboard', routerName:"projects"},
				{iconName: 'tag', routerName:"tags"},
				{iconName: 'people', routerName:"adminusers"},
				{iconName: 'settings_applications', routerName:"role"},
				{iconName: 'admin_panel_settings', routerName:"assign_role"},
        {iconName: 'rate_review', routerName:"createBlog"},
        {iconName: 'label', routerName:"blogs"},
			],
      drawer: true,
        items: [
          { title: ' Home', icon: 'mdi-home-city' },
          { title: ' My Account', icon: 'mdi-account' },
          { title: ' Users', icon: 'mdi-account-group-outline' },
        ],
        mini: true,
      interval:null,
      dat:'',
      invId:0
    }
   
  },
  methods : {
     logout(){
       let item = localStorage.removeItem('storedData')
       console.log("Storage removed",item)
       
     },
    //  compare(date){
    //  let ml = moment(date)
    //  let now = moment();

    //       if (ml < now) {
    //         return true
    //       } else {
    //         return false
    //       }
    //  },
     routeProject(category,i){
		          if(this.$route.fullPath==category.route){
                 location.reload()
              }
              this.$router.push(`${category.route}`)},
		 

  async updateNotification(){
   this.notification.forEach(async inv=>{
					if(this.$store.state.user.id==inv.toUserId){
					    return await this.callApi('put',`/app/update/notification/${this.user.id}`);
					}else{
            return
          }
					});
        
  },         
  async updateNotificationRole(){
			await this.callApi('put','/app/update/role/notification/pend');
				
  }
  },
  

  

   destroyed(){
   clearInterval(this.interval)
   },
  async created(){
  console.log('Heyyy',this.$store.state.notifications)
    // window.Echo.channel('notification')
    //  .listen('ItemAdded',(e) =>{
         
    //      console.log("The socket is here",e)

    // })
  //   window.Echo.channel('notifications').listen('ItemAdded',(e)=>{
  //      console.log('The web socket',e);
  //      console.log('Newest',e.notifications)
  // })
    //console.log('here',moment.now())
    this.$store.commit('setUpdateUser',this.user)
    console.log('The user',this.user)
    console.log("User permissions",this.permission)
    this.$store.commit('setUserPermission',this.permission)
    if(this.user){
    const res = await this.callApi('get','/app/get_roles');
    const notif = await this.callApi('get','/app/notification');
    console.log("The notification",notif.data)
    this.notification = notif.data
    const notifRle = await this.callApi('get',`/app/notification/role/pend/${this.user.role_id}`);
   
          // var audio = new Audio(this.rr.soundurl);
          // audio.play()
    notifRle.data.forEach(inv=>{
    if(this.$store.state.user.role_id==inv.role_id){
        // this.invId = this.$store.state.user.role_id
        console.log('The role', this.invId)
        console.log('Hey socket')
        return this.roleNotifications = notifRle.data
    }else{
        console.log('The final')
        return
    }});
    const notifData = await this.callApi('get',`/app/notification/data/${this.user.id}`);
    this.notificationData = notifData.data
    const notifRleData = await this.callApi('get',`/app/role/notification/data/${this.user.role_id}`);
    this.roleNotificationsData = notifRleData.data
    if(res.status===200){
				this.roles = res.data.data
				console.log("This is the role",this.roles)
				//this.spinShow= false
			}else{
				this.swr()
			}
    }
   
  },
mounted(){
  // window.Echo.channel('notification.'+this.user.id).listen('ItemAdded',(e) =>{
         
  //        console.log("The socket is here",e)

  // })
 window.Echo.channel('notificationdatainvent')
     .listen('NotificationData',(e) =>{
      // console.log("The notification data", e)
      e.invent.forEach(inv=>{
					if(this.$store.state.user.id==inv.toUserId){
					    return this.notificationData = e.invent
					}else{
            return
          }
					});
		
		//  this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
		//  this.pageInfo= e.invent
    });
  window.Echo.channel('notifrledatainvent')
     .listen('NotifRleData',(e) =>{
      // console.log('Notif rle', e.invent)
      e.invent.forEach(inv=>{
         if(this.$store.state.user.role_id==inv.role_id){
					  return this.roleNotificationsData = e.invent
					}else{
            return
          }
					});
					});  
				
		//  this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
		//  this.pageInfo= e.invent
    // });
if(this.$store.state.user.role_id == 1 || this.$store.state.user.role_id == 4){
 window.Echo.channel('notificationpendinvent')
     .listen('NotificationPend',(e) =>{
         console.log("Hello the notification pend request", e.invent.original);
         if(e.invent.original.notification.length === 0){
               console.log('Hello for the 2nd time', this.user.role_id)
               if(this.$store.state.user.id == e.invent.original.userId){
                    console.log('Hello for the 3rd time', this.user.role_id)
                    return this.notifications = e.invent.original.notification
               }else{
                    console.log('The third error')
               }
          }else{
          // var audio = new Audio(this.rr.soundurl);
          // audio.play()
          e.invent.original.notification.forEach(inv=>{
					if(this.$store.state.user.id==inv.toUserId){
              this.invId = this.$store.state.user.role_id
              console.log('The role', this.invId)
              console.log('Hey socket')
					    return this.notifications = e.invent.original.notification
					}else{
              console.log('The final')
              return
          }});
          }
		
		//  this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
		//  this.pageInfo= e.invent
    })
     
    }else{
      window.Echo.channel('notifrleinvent')
       .listen('NotifRle',(e) =>{
         console.log("Hello the role notification pend request", e.invent);
         if(e.invent.original.notification.length === 0){
               console.log('Hello for the 2nd time', this.user.role_id)
               if(this.$store.state.user.role_id == e.invent.original.role_id){
                    console.log('Hello for the 3rd time', this.user.role_id)
                    return this.roleNotifications = e.invent.original.notification
               }else{
                    console.log('The third error')
               }
          }else{
          // var audio = new Audio(this.rr.soundurl);
          // audio.play()
          e.invent.original.notification.forEach(inv=>{
					if(this.$store.state.user.role_id==inv.role_id){
              // this.invId = this.$store.state.user.role_id
              console.log('The role', this.invId)
              console.log('Hey socket')
					    return this.roleNotifications = e.invent.original.notification
					}else{
              console.log('The final')
              return
          }});}
          })
    }
//     notification :async function(){
//       const notif = await this.callApi('get',`/app/notification/${this.user.id}`);
// //       if(notif.data.length){
// //         for (let i = 0; i < cars.length; i++) {
// //   text += cars[i] + "<br>";
// // }
// //         let audio = new Audio(this.rr.soundurl);
// //         audio.play();
// //       }
//       return this.notification = notif.data
     
//     },
//     notificationData :async function(){
//       const notif = await this.callApi('get',`/app/notification/data/${this.user.id}`);
     
//       return this.notificationData = notif.data
     
//     }
  },
computed:{
  ...mapGetters(['getNotification'])
},
watch:{
  getNotification(obj){
    console.log('State object',obj)
  }
}
// computed: {
//    moment: function (date) {
//     return moment(date).fromNow();
//   }}
      // formattedDate(date) {
      // let dd =  moment(date).fromNow();
      // console.log('The time now',dd)
      // return dd
     
      //   }

  // mounted() {
  //    this.getNotif()
  //    this.interval = setInterval(function(){
  //      this.getNotif()
  //    }.bind(this), 500)
  // },
  
}

</script>
<style>
.ss {
  min-width: 0px; top: 45px; left: 917px; transform-origin: left top; z-index: 8;
}
.Sr {
  background: linear-gradient(
        45deg,
        rgba(29, 236, 197, 0.5),
        rgba(91, 14, 214, 0.5) 100%
      ); 
}
</style>
// https://silvawebdesigns.com/bootstrap-4-mobile-nav-bar-slide-from-left-right/