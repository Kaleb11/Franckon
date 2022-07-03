<template>
<div class="bc">
		<div class="content">

			<div class="container-fluid">
				<div class="demo-spin-article">
        
                <Spin size="large" fix v-if="spinShow"></Spin>
            </div>
				
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<div class="row">
					<div class="col-6 col-md-10 col-lg-10">
					<p class="_title0">Role Management</p></div>

					<div class="col-6 col-md-2 col-lg-2">
						<Select v-model="data.id"  @on-change="changeAdmin" placeholder="Select Admin Type" style="width:204px;margin-left: -37px; font-family: Trirong, serif;">
                   <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
                </Select></div>
			    </div>
                    
					<div class="_overflow _table_div">
						<table class="_tableRow">
								<!-- TABLE TITLE -->
							<tr>
								<th>Resource name</th>
								<th>Read</th>
								<th>Write</th>
								<th>Update</th>
								<th>Delete</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(r,i) in resources" :key="i">
								<td>{{r.resourceName}}</td>
								<td><Checkbox v-model="r.read"></Checkbox></td>
								<td><Checkbox v-model="r.write"></Checkbox></td>
								<td><Checkbox v-model="r.update"></Checkbox></td>
								<td><Checkbox v-model="r.delete"></Checkbox></td>
							</tr>
								<!-- ITEMS -->
                            <div class="center_button">
								 <Button v-if="isWritePermitted && loading" type="primary"   style="font-family: Trirong, serif;" loading>Assigning...</Button>
                                 <Button v-if="isWritePermitted && !loading" type="primary"  @click="assignRoles" style="font-family: Trirong, serif;">Assign</Button>
							</div>
								<!-- ITEMS -->
							
								<!-- ITEMS -->


						</table>
					</div>
				</div>
       
		
			</div>
		</div>
	</div>
</template>

<script>
export default{
	 props: ['user','permission'],
     data(){
		 return{
			data : {
				roleName:'',
				id:null
			},
			isSending : false,
			roles: [],
			permissons: [],
			//readApi: 'app/get_tags',writeApi: 'app/create_tag', updateApi: 'app/update_tag', deleteApi: 'app/delete_tag'
			resources : [
				{resourceName: 'projects', read: false, write: false, update: false, delete: false, name:'projects'},
				{resourceName: 'Adminusers', read: false, write: false, update: false, delete: false, name:'adminusers'},
				{resourceName: 'Role', read: false, write: false, update: false, delete: false, name:'role'},
				{resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name:'assign_role'},
				{resourceName: 'Inventory data', read: false, write: false, update: false, delete: false, name:'inventory_data'},
			],
			defaultResourcesPermission : [
				{resourceName: 'projects', read: false, write: false, update: false, delete: false, name:'projects'},
				{resourceName: 'Adminusers', read: false, write: false, update: false, delete: false, name:'adminusers'},
				{resourceName: 'Role', read: false, write: false, update: false, delete: false, name:'role'},
				{resourceName: 'Assign Role', read: false, write: false, update: false, delete: false, name:'assign_role'},
				{resourceName: 'Inventory data', read: false, write: false, update: false, delete: false, name:'inventory_data'},
			],
			spinShow: true,
			loading: false
		 }
	 },
	 methods : {
        async assignRoles(){
			this.loading = true
			let data = JSON.stringify(this.resources)
			const res = await this.callApi('post','app/assign_roles', {'permission':data, id: this.data.id})
            if(res.status==200){
				this.success('Role has been assigned successfully!')
				let index = this.roles.findIndex(role => role.id == this.data.id)
				this.roles[index].permission = data
				let user = JSON.parse(localStorage.getItem('storedData'));
			    if(user.role_id==this.data.id){
				   location.reload();
				}
			
			}else{
				this.swr()
			}
			this.loading = false
		},
		changeAdmin(){
			console.log("The id is",this.data.id)
			let index = this.roles.findIndex(role => role.id == this.data.id)
            let permission = this.roles[index].permission
			console.log(index)
			if(!permission){
				this.resources = this.defaultResourcesPermission
			}else{
                this.resources = JSON.parse(permission)
			}
			
					//this.resources = JSON.parse(res.data.id[id].permission)
				

		},
		checkPermm(){
			var pathArray = window.location.pathname.split('/');
			console.log("The path",pathArray[1])
			// if(pathArray[1]==)
		}
		
	 },
	 
	 async created(){
		    let user = JSON.parse(localStorage.getItem('storedData'));
			console.log("Store permission", this.$store.state.permission)
			console.log("The user",user.role_id)
		    console.log(this.$route)
			var pathArray = window.location.pathname.split('/');
			console.log("The path",pathArray[1])
			this.permissions = this.$store.state.permission
			const res = await this.callApi('get','/app/get_roles');
		    console.log(res.data)
			if(res.status===200){
				this.roles = res.data.data;
				console.log("Hehe", this.roles)
			  if(res.data.data.length){
				this.data.id = res.data.data[4].id
				console.log("Hi",this.data.id)
				if(res.data.data[3].permission){
					this.resources = JSON.parse(res.data.data[4].permission)
				}
			  }
			this.spinShow= false
			}else{
				this.swr()
			}
		},
	
}
</script>