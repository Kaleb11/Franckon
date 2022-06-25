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
						<div class="col-8 col-md-10 col-lg-10">
					<p class="_title0">Projects</p></div>
					<div class="col-4 col-md-2 col-lg-2">
					<Button v-if="isWritePermitted" @click="AddModal()" style="margin-left: -28px;"><Icon type="md-add" />Add project</Button></div>
                    </div>
                    <div class="space"></div>

					<div class="row">
                    <div class="col-xs-12 col-12 col-md-3 col-lg-2">
					<Input type="text" style="width: 200px;" autocomplete="name" placeholder="Search"
					v-if='$store.state.user.role_id != 4'
					v-model="str"
					@input = "searchProjectData"
					v-on:keyup.enter="searchProjectData"
					outlined
					
					ref="search"
					/></div>
					<div class="col-xs-12 col-12 col-md-9 col-lg-10">
						<!-- <Select placeholder="Filter by" style="width: 200px;">
							<Option>None</Option>
							<Optiongroup label="Approval">
                                <Label>Approval</Label>
									<Option value="html">Completed</Option>
									<Option value="css">Failed</Option>
							</Optiongroup>
							<Option>Approved</Option>
							<Option>Completed</Option>
							<Option>Pending</Option>
						</Select> -->
						<!-- <TreeSelect v-model="value" :data="dat" style="width=200px" />
						<!-- <Treeselect v-model="value" :multiple="true" :options="options" /> -->
				    </div>
                    
					</div>
					<div class="space"></div>
					<div class="space"></div>
				      <div class="row">
					   <div class="col-12 col-md-10 col-lg-12">
						<div class="row">


                <div  v-for="(siProject, i) in singleProject" :key="i"  v-if="singleProject.length && $store.state.user.role_id == 4">
					
					 <div class="col-12 col-md-4 col-lg-3">
							
						       
						           <div class="card">
									  
						               <div  @click="routeProjecttwo(siProject,i)"><div class="card-body" >
									   <!-- <span class="badge" v-if="category.nofCount">{{category.nofCount}}
											</span> -->
										<!-- <img src="" class="card-img-top" alt="..."/> -->
										<h5 class="card-title">{{siProject.projectName}}</h5>
										<!-- W:245.73px -->
											
										<img class="card-img-top" :src="siProject.iconImage" style="height: 138.23px;width: 245.73px;" alt="Card image cap" />
											
										
							
					                   </div>
						           </div>
								   <button v-if="isUpdatePermitted" class="card-link" size="small" @click="showEditModal(siProject,i)"> <v-icon class="ic" style="color: #0099ff;">edit</v-icon></button>
								   <button v-if="isDeletePermitted" class="card-link" type="error" size="small" @click="showDeletingmodal(siProject,i)"><v-icon class="ic_delete" style="color: #FE0001;">delete</v-icon></button>
								</div>
						    </div>
				</div>
                






					     <div  v-for="(category, i) in categories" :key="i" v-if="categories.length && ($store.state.user.role_id == 1 || $store.state.user.role_id == 2 || $store.state.user.role_id == 3 || $store.state.user.role_id == 5)">
						    <div class="col-12 col-md-4 col-lg-3">
						
						      
						           <div class="card">
						               
						               <div  @click="routeProject(category,i)"><div class="card-body" >
										<span class="badge" v-if="category.nofCount">{{category.nofCount}}
											</span>
										<!-- <img src="" class="card-img-top" alt="..."/> -->
										<h5 class="card-title">{{category.projectName}}</h5>
										<!-- W:245.73px -->
											
										<img class="card-img-top" :src="category.iconImage" style="height: 138.23px;width: 245.73px;" alt="Card image cap" />
											
										
							
					                   </div>
						           </div>
								   <button v-if="isUpdatePermitted" class="card-link" size="small" @click="showEditModal(category,i)"> <v-icon @click="showEditModal(category,i)" class="ic" style="color: #0099ff;">edit</v-icon></button>
								   <button v-if="isDeletePermitted" class="card-link" type="error" size="small" @click="showDeletingmodal(category,i)"><v-icon class="ic_delete" style="color: #FE0001;">delete</v-icon></button>
								</div>
						    </div>
						 </div>
			</div>
			</div>
			</div>

						<div class="pagspace" v-if="$store.state.user.role_id != 4">
						   
							<Page :total="pageInfo.total"
							      :current="pageInfo.current_page"
								  :page-size="parseInt(pageInfo.per_page)"
								  :on-next="pageInfo.next_page_url"
								  :page-size-opts="[8,10, 20, 50, 100, 500]"
								  @on-change="searchProjectData" 
								  v-if="pageInfo" 
								  show-total
								  show-sizer
								  @on-page-size-change="changePageSize"
								  />
							
						
						</div>
					<!-- </div>
				</div> -->
        <!-- Category adding  modal	 -->
        <Modal
			v-model="imageModal"
			title="Add"
			:mask-closable="false"
			:closable="false">
            
			<Input autocomplete="on" v-model="data.projectName" type="text" placeholder="Add project name" />
            <!-- <div class="space" style="padding: 8px;"></div> -->
			 <div class="space" style="padding: 8px;"></div>
			
            <Upload
			  v-show="!data.iconImage"
			  ref="uploads" 
              type="drag"
			  :headers="{'x-csrf-token' :token,'X-Requested-With':'XMLHttpRequest'}"
			  :on-success="handleSuccess"
              :format="['jpg','jpeg','png']"
			  :on-format-error="handleFormatError"
              :max-size="2048"
              :on-error="handleError"
              :on-exceeded-size="handleMaxSize"
              action="/app/upload/project/image">
            <div style="padding: 20px 0">
               <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                <p>Click or drag files here to upload</p>
            </div>
            </Upload>
			<div class="demo-upload-list" v-if="data.iconImage">
            
                <img :src= "`/uploads/Project Images/${data.iconImage}`">
            <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click="deleteImage()"></Icon>
            </div>
               
            </div>
           
			
               
            
			<!-- <div class="image_thumb" v-if="data.iconImage">
				 <img :src = "`/uploads/${data.iconImage}`" style="width: 26%;" />
			</div> -->
			<div slot="footer">
				<Button type="default" @click="onClosingImage()">Close</Button>
				<Button type="primary" style="color:white" v-if="loading" loading>Adding...</Button>
                <Button type="primary" style="color:white" v-if="!loading" :loading="loading" @click="addCategory">Add Project</Button>
				<!-- <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...': 'Add Project'}}</Button> -->
			</div>
		</Modal>
		<!-- Edit modal -->
		 <Modal
			v-model="editModal"
			title="Edit project"
			:mask-closable="false"
			:closable="false">
			<Input type="text" autocomplete="on" v-model="editData.projectName" v-if="!hasInventory" placeholder="Add project name" />
			<Input type="disabled" readonly v-model="editData.projectName" v-if="hasInventory"/>
            <div class="space" style="padding: 8px;"></div>
			
            <Upload
			  v-show="isIconImageNew && !editData.iconImage"
			  ref="editDataUploads" 
              type="drag"
			  :headers="{'x-csrf-token' :token,'X-Requested-With':'XMLHttpRequest'}"
			  :on-success="handleSuccess"
              :format="['jpg','jpeg','png']"
			  :on-format-error="handleFormatError"
              :max-size="2048"
              :on-error="handleError"
              :on-exceeded-size="handleMaxSize"
              action="/app/upload/project/image">
            <div style="padding: 20px 0" >
               <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                <p>Click or drag files here to upload</p>
            </div>
            </Upload>
			<div class="demo-upload-list" v-if="editData.iconImage">
               
                <img :src= "`${editData.iconImage}`">
            <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
            </div>
               
            </div>
			<div slot="footer">
				<Button type="default" @click="onClosingImage(false)">Close</Button>
				<Button type="primary" style="color:white" v-if="loading" loading>Editing...</Button>
                <Button type="primary" style="color:white" v-if="!loading" :loading="loading" @click="editCategory">Edit Project</Button>
				<!-- <Button type="primary" @click="editCategory" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing...': 'Edit project'}}</Button> -->
			</div>
		</Modal>
            
    <!-- Full screen modal -->
		<Modal v-model="viewInfoModal" fullscreen title="Category Info">
               <p>Category Name: {{viewData.categoryName}}</p>
			   <p>Icon Image</p>
			   <div class="demo-infoview-list" v-if="viewData.iconImage">
               
                <img :src= "`${viewData.iconImage}`">
			   </div>
			   <p>Created at: {{viewData.created_at}}</p>
			   <div slot="footer">
				<Button type="default" @click="viewInfoModal=false">Close</Button>
			</div>
        </Modal>
		<deleteModal></deleteModal>
		<!-- <Modal
			v-model="showDelete"
			width="360">
		<p slot="header" style="color:#f60;text-align:center">
			<Icon type="ios-information-circle"></Icon>
			<span>Delete confirmation</span>
		</p>
		<div style="text-align:center">
			<p>Are you sure you want to delete tag?</p>
			
		</div>
		<div slot="footer">
			<Button type="error" size="large" long : loading="showDeleteModal" :disabled="showDeleteModal"  @click="deleteTag">Delete</Button>
		</div>
		</Modal> -->
		     </div>
			</div>
		</div>
	</div>
</template>

<script>
import deleteModal from '../components/deleteModal.vue'
import { mapGetters } from 'vuex'
export default{
     data(){
		 return{
			data : {
				projectName:'',
				requestUser:'',
				iconImage:''
			},
			itm:{
				resetImage:''
			},
			editModal: false,
			addModal : false,
			isAdding : false,
			isEditing : false,
			categories : [],
			editData: {
			
			},
			viewData:{},
			index : -1,
			showDeleteModal: false,
			isDeleting:false,
			deleteItem:{},
			singleProject:[],
			notification:[],
			nof:[],
			// deletingIndex:-1,
			viewInfoModal:false,
			token: '',
			imageModal:false,
			res:'',
			spinShow: true,
			isIconImageNew:false,
			isEditingg:false,
			img:'',
			isOnEditing:false,
			total: 8,
			pageInfo:null,
			str:'',
			hasInventory:false,
			loading:false
		 }
	 },
	 
	 methods : {
		async addCategory(){
		  this.data.requestUser = this.$store.state.user.fullName
          if(this.data.projectName.trim()=='') return this.error('Category name is required')
		  if(this.data.requestUser=='') return this.error('Icon image is required')
		  this.isAdding=true
	      this.loading = true
		  console.log('The request user is', this.data.requestUser)
		  this.data.iconImage = `/uploads/Project Images/${this.data.iconImage}`
		  const res = await this.callApi('post','/app/create_category',this.data)
	      if(res.status===201){
		      this.categories.unshift(res.data)
              this.success('Project has been added successfully!')
			  this.getCategoryData()
			  this.imageModal = false
			  this.data.projectName = ''
			  this.data.iconImage = ''
			  this.$refs.uploads.clearFiles()
			  this.isAdding=false
		  }else{
	        if(res.status===422){
				if(res.data.errors.categoryName){
					
					this.error(res.data.errors.categoryName[0])
					
				}
				
                 console.log(res.data.errors.categoryName)
				 console.log(res.data.errors.iconImage)

			}else{
				console.log(this.data.iconImage)
				this.swr()
			}
			  
		  }
		  this.loading = false
		 },

        async editCategory(){
		  this.loading = true
		  this.editData.requestUser = this.$store.state.user.fullName
          if(this.editData.projectName.trim()=='' || this.editData.projectName == '') return this.error('Project name is required')
		  if(this.editData.iconImage=='') return this.error('Project image is required')
		  this.editData.iconImage = this.editData.iconImage
		  const res = await this.callApi('put','/app/update_category',this.editData)
	      if(res.status===200){
			  
			  
		      this.categories[this.index].projectName = this.editData.projectName
			  this.categories[this.index].iconImage= this.editData.iconImage
              this.success('Project has been edited successfully!')
			  this.editModal = false
			  this.isIconImageNew=false
			  //this.data.tagName = ''
		  }else{
	        if(res.status==422){
				if(res.data.errors.projectName){
					console.log("First error")
					this.error(res.editData.errorsName[0])
				}
				console.log("Second error")
                console.log(res.data.errors.projectName)
			}else{
				
				this.swr()
			}
			  
		  }
		  this.loading = false
		 },
		async showEditModal(category,index){
			const res = await this.callApi('get','/app/inventory_data')
			this.isOnEditing=true
			if(res.status == 200){
			   if(res.data.length != 0){
			   res.data.forEach(inv => {
				 if(inv.category_id == category.id){
					console.log(inv.category_id)
                    this.hasInventory=true
					console.log('The data', inv)
					return inv
				 }else{
					// this.swr()
					// return this.hasInventory=false
				 }
			   })
            //    console.log('The inventory data', this.hasInventory)
			   }
			}else{
				this.swr()
			}
			let obj = {
				id:category.id,
				projectName:category.projectName,
			    iconImage:category.iconImage
			}
		    this.editData = obj
			this.editModal=true
			this.index = index
			this.isEditingg=false
	     },
	 async routeProject(category,i)
        {
          
		  if(this.isReadInventoryPermitted){
              this.$router.push(`/${category.projectName}/inventory_data/${category.id}`);
			  await this.callApi('put',`/app/update/project/notification/pend/${category.id}`)
			  }
		  else{
			   this.$router.push('/')
		  }
               },
	  routeProjecttwo(siProject,i)
        {
          
		  if(this.isReadInventoryPermitted){
              this.$router.push(`/${siProject.projectName}/inventory_data/${siProject.id}`);
			  }
		  else{
			   this.$router.push('/')
		  }
               },				
		showDeletingmodal(category,i){
		const deleteModalObj = {
            showDeleteModal: true,
            deleteUrl: 'app/delete_category',
            data: category,
            deletingIndex: i,
            isDeleted: false,
			msg: 'Are you sure delete this project?',
			successmsg:'Project has been deleted successfully!!!'
        }
		this.$store.commit('setDeletingModalObj',deleteModalObj)
			// this.deleteItem = category
			// this.deletingIndex=i
			// this.showDeleteModal = true
            // if(!confirm('')) return
            // //tag.isDeleting = true
			// this.$set(tag,'isDeleting',true)
		},
		viewInfo(category){
			this.viewInfoModal =true
			let obj = {
				id:category.id,
				categoryName:category.categoryName,
				iconImage:category.iconImage,
				created_at:category.created_at
			}
		    this.viewData = obj

		},
		handleSuccess (res, file) {  
			if(this.isOnEditing){
				this.editData.iconImage = `/uploads/Project Images/${res}`
				console.log(this.editData.iconImage)
			}else{
				
				
			     console.log("Here")
			     this.data.iconImage = res
				 console.log(this.data.iconImage)
				 }   
            },
		
        handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
       handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
		handleError(res,file){
         this.$Notice.warning({
                   title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!!'}`
                });
		},
		AddModal(isAdd=true){
			this.imageModal=true
		},
		onClosingImage(isAdd=true){
		   //this.isIconImageNew=false
		   if(!isAdd){
			 this.isOnEditing=false
			 this.isIconImageNew=false
			 this.editModal=false
			 this.$refs.editDataUploads.clearFiles()
			 this.isEditing=false
			 this.hasInventory=false
		   }else{
		  
		   
		   this.data.projectName=''
		   this.imageModal=false
		   
		  
		   }
		},
		async deleteImage(isAdd=true){
			if(!isAdd){ // for editing.....
			    // this.editData.iconImage=''
			    // this.$refs.clearFiles()
				
                this.isIconImageNew=true
				this.img = this.editData.iconImage
			    this.editData.iconImage=''
			    this.$refs.editDataUploads.clearFiles()
				this.isAdd=false
			}else{
			this.$refs.uploads.clearFiles() 
			this.img = this.data.iconImage
			this.data.iconImage=''
			
			}
			const res = await this.callApi('post','app/delete_image',{iconImage:this.img})
			// this.isIconImageNew=true
			if (res.status!=200){
               this.data.iconImage = this.img
			   this.swr()
			}
		},
		async searchProjectData(page=1){
				   
					const res = await this.callApi('get',`/app/search_project?str=${this.str}&page=${page}&total=${this.total}`);
					
					if(res.status===200){
						this.categories = res.data.data;
						this.pageInfo = res.data;	
							}else{
								this.swr()
							}
					},
		changePageSize(page){
						//s page size
						if(!this.str){
							this.pageInfo.index = 1;
							this.total = page;
							this.catData();
						}else{
							this.pageInfo.index = 1;
							this.total = page;
							this.searchProjectData();
						}
						
					},
		async catData(page=1){
		
	    const res = await this.callApi('get',`/app/get_category?page=${page}&total=${this.total}`);
		this.categories = res.data.data
		this.categories.forEach((element)=>{
					console.log('The true here')
					element.nofCount=0;
					this.notification.forEach(notif=>{
					if(element.id==notif.project_id && notif.role_id == this.$store.state.user.role_id){
					console.log('The true')
				    element.nofCount++;
					//this.categories[this.index].element.nofCount++
					// element.set("nofCount",element.nofCount++)
					// element.map(category => ({ nofCount : element.nofCount++, ...category }))
					console.log('The element', element.nofCount)
					}else{
						return
					}
					});
				});
				},
		async getCategoryData(page = 1){
		
			this.token=window.Laravel.csrfToken
			const res = await this.callApi('get',`/app/get_category?page=${page}&total=${this.total}`);
			let idd = this.$store.state.user.category_id
			const pro = await this.callApi('get',`/app/project/${idd}`);
		    const notif = await this.callApi('get',`/app/project/notification/pend`);
            this.notification = notif.data
			console.log('This notification', notif.data)
			if(res.status===200){
				let techStack = localStorage.getItem("storedData");
                console.log(techStack);
				

				this.categories = res.data.data
				this.categories.forEach((element)=>{
					console.log('The true here')
					element.nofCount=0;
					this.notification.forEach(category=>{
					if(element.id==category.project_id && category.role_id == this.$store.state.user.role_id){
					console.log('The true')
					element.nofCount++;
					console.log('The element', element.nofCount)
					}
					});
				});
				// this.categories = res.data.data
				console.log('The category data',this.categories)
		        this.pageInfo = res.data
				this.spinShow= false
			}else{
				this.swr()
			}
			if(pro.status===200){
			    this.singleProject = pro.data
				console.log('The project data',this.singleProject)
		       
			}else{
				console.log("Here is the error")
				// this.swr()
			}
		},
	 },
	 
	 async created(){
		 
	        this.getCategoryData()
			this.searchProjectData()

    
			
			
			// this.notification.forEach(async (not) => {
			// const rr = await this.callApi('get',`/project/notification/pending/${not.project_id}`);	
			// this.nof = rr
			// console.log('The Pending data',this.nof)
			// });
		},
	components:{
        deleteModal,
	 },
	computed:{
		  ...mapGetters(['getDeleteModalObj']),
	 },
    watch:{
     getDeleteModalObj(obj){
	      console.log(obj)
		  console.log(obj.isDeleted)
		  if(obj.isDeleted){
			  
			  this.categories.splice(obj.deletingIndex,1)
			  console.log("Hey")
		  }
	   },
	    
	// nof :async function(projectID){
    //   const notif = await this.callApi('get',`/app/project/notification/pending/${projectID}`);
    //   console.log("The nofff",notif)
	//   return this.nof = notif.data
     
    // },
	//   notification :async function(){
    //   const notif = await this.callApi('get',`/app/project/notification/pend`);
    //   this.notification = notif.data


    //   },
    //   categories :async function(page=1){
    //   const res = await this.callApi('get',`/app/get_category?page=${page}&total=${this.total}`);
	//   this.categories = res.data.data
    //   this.categories.forEach((element)=>{
	// 				//console.log('Rrrr')
	// 				element.nofCount=0;
	// 				this.notification.forEach(category=>{
	// 				if(element.id==category.project_id){
	// 				//console.log('The true')
	// 				element.nofCount++;
	// 				//console.log('The element', element.nofCount)
	// 				}
	// 				});
	// 			});
     
    // },
// rr(){
// 	 (this.categories).foreach((element)=>{
// 		console.log('The true')
// 		element.nofCount=0;
// 		this.notification.foreach(category=>{
// 		if(element.id==category.project_id){
// 		console.log('The second true')
// 		element.nofCount++;
// 		console.log('The element', element.nofCount)
// 		}
// 		});
// 	 }); 
// }
// 	},	
	    
	//  watch : {
      
	//  }
//    async created(){
// 	   const res = await this.callApi('post','/app/create_tag',{tagName:'testertag'});
	  
// 	   if(res.status==200){
// 		  // console.log(res)
// 	   }else{
// 		   console.log(res)
// 		   console.log('running')
// 	   }
//    }
	},
mounted(){
// const res = await this.callApi('get',`/app/get_category?page=${page}&total=${this.total}`);
// this.categories = res.data.data
console.log('Category items are',this.categories)
 window.Echo.channel('notificationprojectpendinvent')
     .listen('NotificationProjectPend',(e) =>{
         console.log("The project socket here",e);
		 this.notification = e.invent;
		 let page = 1;
		 this.catData();
		//  axios.get(`/app/get_category?page=${page}&total=${this.total}`).then(function(response){
        //        console.log('Pp',response.data.data)
		// 	   this.categories = response.data.data
		//  })
		//  this.getCategoryData();
		//  this.categories.forEach((element)=>{
		// 			console.log('The true here')
		// 			element.nofCount=0;
		// 		this.notification.forEach(category=>{
		// 			if(element.id==category.project_id){
		// 			console.log('The true')
		// 			let nofCount = element.nofCount++;
		// 			this.categories.push(nofCount)
		// 			console.log('The element of notification count is', element.nofCount)

		// 			}
		// 			});
		// 		});
		//  this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
		//  this.pageInfo= e.invent
    })
}
}
</script>
<style>
.card {
    width: 18rem;
	border-radius: 4px;
    background-color: #e0c9cc;
    box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
    transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
  
    cursor: pointer;

}
button {
    display: none;
}
.card:hover{
  background: linear-gradient(
        45deg,
        rgba(29, 236, 197, 0.5),
        rgba(91, 14, 214, 0.5) 100%
      ); 
  
  transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
 
}
.card:hover button {
    display: flex;
	 
 
}
.ic:hover {
	background-color:#173b67;
    transition: 0.7s;
}
.ic_delete:hover {
	background-color:#6f0202;
    transition: 0.7s;
}
.ic {
  color: blue;
  background-color: white;
  border-radius: 50%;
  border: 1px solid grey;
  padding: 2px;
  margin-top:-18px;
  margin-bottom: 3px;
  margin-left:18px;
}

.ic_delete{
	 color: red;
	 background-color: white;
	 border-radius: 50%;
	 border: 1px solid grey;
	 padding: 2px;
	 margin-left: 219px;
	 margin-top:-33px;
}
.badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 7px;
  border-radius: 50%;
  background: red;
  color: white;
}
</style>