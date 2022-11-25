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
					<p class="_title0" v-if="projectName">{{projectName}}</p></div>
					<div class="col-6 col-md-2 col-lg-2">
					<Button v-if="isWritePermitted" @click="addModal=true"  style="margin-left: 23%; font-family: Trirong, serif;"><Icon type="md-add" />Add New Item</Button></div>
					</div>



					<div class="row">
                    <div class="col-xs-12 col-12 col-md-3 col-lg-2">
					<Input type="text" style="width: 200px;" autocomplete="name" placeholder="Search" 
					v-model="str"
					@input = "searchInventoryData"
					v-on:keyup.enter="searchInventoryData"
					outlined
					
					ref="search"/></div>
					<div class="col-xs-12 col-12 col-md-9 col-lg-10">
						<Select placeholder="Filter by" style="width: 200px;">
							<Option>None</Option>
							<Optiongroup label="Approval">
                                <Label>Approval</Label>
									<Option value="html">Completed</Option>
									<Option value="css">Failed</Option>
							</Optiongroup>
							<Option>Approved</Option>
							<Option>Completed</Option>
							<Option>Pending</Option>
						</Select>
						<!-- <TreeSelect v-model="value" :data="dat" style="width=200px" />
						<!-- <Treeselect v-model="value" :multiple="true" :options="options" /> -->
				    </div>
                    
					</div>

                    <div class="space"></div>
					<div class="_overflow _table_div">
						<!-- <table v-bind:class="{'_table': $store.state.user.role_id == 1,  '_tableRow': $store.state.user.role_id != 1}"> -->
								<!-- TABLE TITLE -->
							<!-- <tr>
								<th>Action</th>
								<th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 2 || $store.state.user.role_id == 3 || $store.state.user.role_id == 5">Status</th>
								<th>Approval</th>
								<th>Item Type</th>
								<th>Quantity</th>
                                <th>Measurenment</th>
                                <th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 2 || $store.state.user.role_id == 3">With Purchase</th>
								<th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 3 || $store.state.user.role_id == 5">From store</th>
								<th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 2 || $store.state.user.role_id ==5">Bought</th>
								<th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 2 || $store.state.user.role_id ==5">Purchased Company</th>
                                <th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 2 || $store.state.user.role_id == 5">Reset</th>
                                
                                
                                <th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 5">Delivered</th>
								<th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 5">Undelivered</th>
								<th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 5">Undelivered Reason</th>
                                <th v-if="$store.state.user.role_id == 1 || $store.state.user.role_id == 4">Order Reason</th>
								<th v-show="$store.state.user.role_id == 1">Approval 1</th>
								<th v-show="$store.state.user.role_id == 1">Approval 2</th>
								<th v-show="$store.state.user.role_id == 1">Urgent</th>
								<th v-show="$store.state.user.role_id == 1 || $store.state.user.role_id == 5">Delivered Time</th>
                                <th>Created Date</th>
								
							</tr> -->
								<!-- TABLE TITLE -->
    


                        <v-data-table
						    v-if="$store.state.user.role_id == 5"
						    :loading="loading"
							loading-text="Loading... Please wait"
							:headers="storeKeeperTwoHeader"
							:items="frmStoreItems"
							:items-per-page="parseInt(pageInfo.per_page)"
							:server-items-length="parseInt(pageInfo.total)"
							:hide-default-footer="true"
                            :footer-props="{
								showFirstLastPage: true,
								firstIcon: 'mdi-arrow-collapse-left',
								lastIcon: 'mdi-arrow-collapse-right',
								prevIcon: 'mdi-minus',
								nextIcon: 'mdi-plus'
								}"

							class="elevation-1"
							item-key="name"
							style="width: 97%;margin-left: 2px;/* border-left: 23px; */"
							
							
							>

                        <!-- Store keeper 2 -->
					<template v-slot:item="{ item,index}"  v-if="$store.state.user.role_id == 5">
                       <tr v-bind:class="{'selected': item.urgent,  '': !item.urgent}">
								<td class="tds">
									<Button
									v-if="isUpdatePermitted"
									type="default" 
									@click="editItem(index)"
									class="button-action"
									
									>

									<Icon v-if="!item.isEditable" style="color: blue;" type="ios-create-outline" />
									<Icon v-if="item.isEditable" type="ios-document" @click="edit(item,index)" />
									<!-- {{item.isEditable ? 'save' : ''  }} -->
									
									</Button>
                                    
                                    

									<Button
									v-if="!item.isEditable && isDeletePermitted"
									type="default" 
									@click="showDeletingmodal(item,index)"
									class="button-action"
									>
									{{item.isEditable ? 'save' : '' }}
									<Icon style="color: red;" type="ios-trash" />
									</Button>
								</td>
                                

								    <!-- <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"></td>	
                                    <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.urgent"></td>	
                                    <td class="selected" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' &&  item.urgent"><img src="/uploads/Urgent.gif" style="height: 18px;width: 18px;" v-if="item.urgent"/></td> -->
								
								
								 <td    class="pt-3-half">
									 
									<div>
									<Button style="width: 91px;height: 25px;" v-if="item.status=='Completed'" id="rcorners1"        
									
									
									>
									<div style="margin-top: -5px;">
											<div style="margin-left: -83px;margin: 4p;margin-top: 1px;"><Icon style="color: white; */" v-if="item.status=='Completed'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -1px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button></div>


                                    <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.status}}...</div>
									</div>
									</Button>
									</div>



                                <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Failed'" id="rcorners3">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Failed'" type="ios-alert-outline" /></div>
											<div style="margin-right: 11px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button>
									</div>



									</td>
								<td   class="pt-3-half">
									<div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='approved'" id="rcorners1">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='approved'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.approved}}</div>
									</div>
									</Button>
									</div>

									 <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -59px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -25px;margin-top: -18px;">{{item.approved}}...</div>
									</div>
									</Button>
									</div>

									</td>
								<td class="pt-3-half">
									<input        
									v-model="item.itemType"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable}"
									>
									</td>
                                <td class="pt-3-half">
									<input
									style="width: 96px;"        
									v-model="item.quantity"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>
                                <td  >
									<Select v-model="item.measurenment" :disabled="!item.isEditable" :class="{'editable': item.isEditable}"
									>
										<Option :value="measure.name" :disabled="!item.isEditable" v-for="(measure, index) in measurenments" :key="i" v-if="measurenments.length">{{measure.name}}</Option>
										</Select>
									<!-- <input        
									v-model="item.measurenment"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									> -->

									</td>
                                
								<td class="tds" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
                                <td class="tds" v-if="item.approved=='approved' && item.withPurchase"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds"  v-if="item.approved=='approved' && !item.withPurchase" ><Checkbox @input="frmStore(item,index)"  onclick="return false;" v-model="item.fromStore"><h6></h6></Checkbox></td>

                                <td class="tds" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-if="item.approved=='approved' && !item.withPurchase"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds" v-if="item.approved=='approved' && item.withPurchase" ><Checkbox @input="onBought(item,index)"  onclick="return false;" v-model="item.bought"><h6></h6></Checkbox></td>


                                <td  v-if="item.approved=='Pending'"><input type="text" value="Need approval" style="font-size: 11px; color: red;" readonly /></td>
								<td  v-if="item.approved=='approved' && !item.withPurchase"><input type="text" value="Disabled" style="font-size: 11px; color: red;" readonly /></td>
                                <td   v-if="item.approved=='approved' && item.withPurchase"  class="pt-3-half" contenteditable="true">
									<input 
									value="Purchased"       
									v-model="item.purchasedCompany"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>


								<td  v-if="item.approved=='Pending'" ><input type="text" value="Need approval" style="font-size: 11px; color: red;" readonly/></td>
								<td  v-if="item.approved=='approved' && !item.withPurchase"><input type="text" value="Disabled" style="font-size: 11px; color: red;" readonly/></td>	
                                <td  v-if="item.approved=='approved' && item.withPurchase" @click="confirmRst(item,index)" v-bind:class="{'resetSelected': item.resetImage,  '': !item.resetImage}"><a v-if="item.resetImage"><img :src="item.resetImage" style="height: 27px;width: 32px;" v-if="item.resetImage"/></a> </td>



                                
								<td  v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td  v-if="item.approved=='approved' && (!item.withPurchase && !item.fromStore)"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td    v-if="item.approved=='approved'  && (item.withPurchase || item.fromStore)" ><Checkbox @input="checkDelivered(item,index)" v-model="item.delivered"><h6></h6></Checkbox></td>


                                
								<td  v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td  v-if="item.approved=='approved' && (!item.withPurchase && !item.fromStore)"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td    v-if="item.approved=='approved'  && (item.withPurchase || item.fromStore)" ><Checkbox @input="checkUnDelivered(item,index)" v-model="item.undelivered"><h6></h6></Checkbox></td>
                        
								<td   class="pt-3-half">
									<input type="text" :readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"  v-model="item.undeliveredReason"></td>
								


                                <td class="tds" v-if="item.approved=='Pending'" ></td>
								<td class="tds" v-if="item.approved=='approved' && !item.deliveredTime" ></td>
								<td class="tds" v-if="item.approved=='approved' &&  item.deliveredTime">{{new Date(item.deliveredTime).toLocaleDateString("en-US")}}<span style="font-size: 11px;"><br>({{ item.deliveredTime | moment("from","now",true) }} ago)</span></td>
                                <td class="tds">{{new Date(item.created_at).toLocaleDateString("en-US")}}</td>
								
							</tr>
					        </template>
                           </v-data-table>
						    










                            
                        <v-data-table
						    v-if="$store.state.user.role_id == 2"
						    :loading="loading"
							loading-text="Loading... Please wait"
							:headers="purchaserHeader"
							:items="withPurchasedItems"
							:items-per-page="parseInt(pageInfo.per_page)"
							:server-items-length="parseInt(pageInfo.total)"
							:hide-default-footer="true"
                            :footer-props="{
								showFirstLastPage: true,
								firstIcon: 'mdi-arrow-collapse-left',
								lastIcon: 'mdi-arrow-collapse-right',
								prevIcon: 'mdi-minus',
								nextIcon: 'mdi-plus'
								}"

							class="elevation-1"
							item-key="name"
							style="width: 97%;margin-left: 2px;/* border-left: 23px; */"
							
							
							>
                            <template v-slot:item="{ item,index}"  v-if="$store.state.user.role_id == 2">
	                        <!-- Purchaser -->
                             <tr v-bind:class="{'selected': item.urgent,  '': !item.urgent}"  v-if="item.withPurchase==true">
								<td class="tds">
									
									<Button
									v-if="isUpdatePermitted"
									type="default" 
									@click="editItem(index)"
									class="button-action"
									
									>

									<Icon v-if="!item.isEditable" style="color: blue;" type="ios-create-outline" />
									<Icon v-if="item.isEditable" type="ios-document" @click="edit(item,index)" />
									<!-- {{item.isEditable ? 'save' : ''  }} -->
									
									</Button>
                                    
                                    

									<Button
									v-if="!item.isEditable && isDeletePermitted"
									type="default" 
									@click="showDeletingmodal(item,index)"
									class="button-action"
									>
									{{item.isEditable ? 'save' : '' }}
									<Icon style="color: red;" type="ios-trash" />
									</Button>
								</td>
                                

								    <!-- <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"></td>	
                                    <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.urgent"></td>	
                                    <td class="selected" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' &&  item.urgent"><img src="/uploads/Urgent.gif" style="height: 18px;width: 18px;" v-if="item.urgent"/></td> -->
								
								
								 <td  v-show="$store.state.user.role_id == 1 || 3"  class="pt-3-half">
									 
									<div>
									<Button style="width: 91px;height: 25px;" v-if="item.status=='Completed'" id="rcorners1"        
									
									
									>
									<div style="margin-top: -5px;">
											<div style="margin-left: -83px;margin: 4p;margin-top: 1px;"><Icon style="color: white; */" v-if="item.status=='Completed'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -1px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button></div>


                                    <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.status}}...</div>
									</div>
									</Button>
									</div>



                                <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Failed'" id="rcorners3">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Failed'" type="ios-alert-outline" /></div>
											<div style="margin-right: 11px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button>
									</div>



									</td>
								<td   class="pt-3-half">
									<div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='approved'" id="rcorners1">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='approved'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.approved}}</div>
									</div>
									</Button>
									</div>

									 <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -59px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -25px;margin-top: -18px;">{{item.approved}}...</div>
									</div>
									</Button>
									</div>

								</td>
								<td class="pt-3-half">
									<input        
									v-model="item.itemType"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable}"
									>
									</td>
                                <td class="pt-3-half">
									<input
									style="width: 96px;"        
									v-model="item.quantity"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>
                                <td  >
									<Select v-model="item.measurenment" :disabled="!item.isEditable" :class="{'editable': item.isEditable}"
									>
										<Option :value="measure.name" :disabled="!item.isEditable" v-for="(measure, index) in measurenments" :key="i" v-if="measurenments.length">{{measure.name}}</Option>
										</Select>
									<!-- <input        
									v-model="item.measurenment"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									> -->

									</td>

                                <td class="tds" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-if="item.approved=='approved' && item.fromStore"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Disabled</Checkbox></td>
								<td class="tds" v-if="item.approved=='approved' && !item.fromStore"><Checkbox @input="withPurchasee(item,index)" v-model="item.withPurchase" onclick="return false;"><h6></h6></Checkbox></td>
                                


								<td class="tds" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-if="item.approved=='approved' && !item.withPurchase"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds" v-if="item.approved=='approved' && item.withPurchase" ><Checkbox @input="onBought(item,index)" v-model="item.bought"><h6></h6></Checkbox></td>


                                <td class="tds" v-if="item.approved=='Pending'"><input type="text" value="Need approval" style="font-size: 11px; color: red;" readonly /></td>
								<td class="tds" v-if="item.approved=='approved' && !item.withPurchase"><input type="text" value="Disabled" style="font-size: 11px; color: red;" readonly /></td>
                                <td v-if="item.approved=='approved' && item.withPurchase"  class="pt-3-half" contenteditable="true">
									<input 
									value="Purchased"       
									v-model="item.purchasedCompany"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>


								<td class="tds" v-if="item.approved=='Pending'" ><input type="text" value="Need approval" style="font-size: 11px; color: red;" readonly/></td>
								<td class="tds" v-if="item.approved=='approved' && !item.withPurchase"><input type="text" value="Disabled" style="font-size: 11px; color: red;" readonly/></td>	
                                <td class="tds" v-if="item.approved=='approved' && item.withPurchase" @click="confirmRst(item,index)" v-bind:class="{'resetSelected': item.resetImage,  '': !item.resetImage}"><a v-if="item.resetImage"><img :src="item.resetImage" style="height: 27px;width: 32px;" v-if="item.resetImage"/></a> </td>



								<td class="tds">{{new Date(item.created_at).toLocaleDateString("en-US")}}</td>
							</tr>
						 </template>
                        </v-data-table>








                            <v-data-table
						    v-if="$store.state.user.role_id == 3"
						    :loading="loading"
							loading-text="Loading... Please wait"
							:headers="mainStoreKeeperHeader"
							:items="approvedItems"
							:items-per-page="parseInt(pageInfo.per_page)"
							:server-items-length="parseInt(pageInfo.total)"
							:hide-default-footer="true"
                            :footer-props="{
								showFirstLastPage: true,
								firstIcon: 'mdi-arrow-collapse-left',
								lastIcon: 'mdi-arrow-collapse-right',
								prevIcon: 'mdi-minus',
								nextIcon: 'mdi-plus'
								}"

							class="elevation-1"
							item-key="name"
							style="width: 97%;margin-left: 2px;/* border-left: 23px; */"
							
							
							>
                            <template v-slot:item="{ item,index}"  v-if="$store.state.user.role_id == 3">
	                        <!-- Store keeper -->
                            <tr v-bind:class="{'selected': item.urgent,  '': !item.urgent}" v-if="item.approved=='approved' && $store.state.user.role_id == 3">
								<td class="tds">
									
									<Button
									v-if="isUpdatePermitted"
									type="default" 
									@click="editItem(index)"
									class="button-action"
									
									>

									<Icon v-if="!item.isEditable" style="color: blue;" type="ios-create-outline" />
									<Icon v-if="item.isEditable" type="ios-document" @click="edit(item,index)" />
									<!-- {{item.isEditable ? 'save' : ''  }} -->
									
									</Button>
                                    
                                    

									<Button
									v-if="!item.isEditable && isDeletePermitted"
									type="default" 
									@click="showDeletingmodal(item,index)"
									class="button-action"
									>
									{{item.isEditable ? 'save' : '' }}
									<Icon style="color: red;" type="ios-trash" />
									</Button>
								</td>
                                

								    <!-- <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"></td>	
                                    <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.urgent"></td>	
                                    <td class="selected" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' &&  item.urgent"><img src="/uploads/Urgent.gif" style="height: 18px;width: 18px;" v-if="item.urgent"/></td> -->
								
								
								 <td  v-show="$store.state.user.role_id == 1 || 3"  class="pt-3-half">
									 
									<div>
									<Button style="width: 91px;height: 25px;" v-if="item.status=='Completed'" id="rcorners1"        
									
									
									>
									<div style="margin-top: -5px;">
											<div style="margin-left: -83px;margin: 4p;margin-top: 1px;"><Icon style="color: white; */" v-if="item.status=='Completed'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -1px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button></div>


                                    <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.status}}...</div>
									</div>
									</Button>
									</div>



                                <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Failed'" id="rcorners3">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Failed'" type="ios-alert-outline" /></div>
											<div style="margin-right: 11px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button>
									</div>



									</td>
								<td   class="pt-3-half">
									<div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='approved'" id="rcorners1">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='approved'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.approved}}</div>
									</div>
									</Button>
									</div>

									 <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -59px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -25px;margin-top: -18px;">{{item.approved}}...</div>
									</div>
									</Button>
									</div>

								</td>
								<td class="pt-3-half">
									<input        
									v-model="item.itemType"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable}"
									>
									</td>
                                <td class="pt-3-half">
									<input
									style="width: 96px;"        
									v-model="item.quantity"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>
                                <td  >
									<Select v-model="item.measurenment" :disabled="!item.isEditable" :class="{'editable': item.isEditable}"
									>
										<Option :value="measure.name" :disabled="!item.isEditable" v-for="(measure, i) in measurenments" :key="i" v-if="measurenments.length">{{measure.name}}</Option>
										</Select>
									<!-- <input        
									v-model="item.measurenment"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									> -->

									</td>
                                <td class="tds" v-show="$store.state.user.role_id == 1 || 3" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1 || 3" v-if="item.approved=='approved' && item.fromStore"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Disabled</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id ==1 || 3" v-if="item.approved=='approved' && !item.fromStore"><Checkbox @input="withPurchasee(item,index)" v-model="item.withPurchase"><h6></h6></Checkbox></td>
                                
								<td v-show="$store.state.user.role_id == 1 || 3" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
                                <td v-show="$store.state.user.role_id == 1 || 3" v-if="item.approved=='approved' && item.withPurchase"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td  v-show="$store.state.user.role_id ==1 || 3" v-if="item.approved=='approved' && !item.withPurchase" ><Checkbox @input="frmStore(item,index)" v-model="item.fromStore"><h6></h6></Checkbox></td>
								<td class="tds">{{new Date(item.created_at).toLocaleDateString("en-US")}}</td>
							</tr>
							</template>
							</v-data-table>



 <v-data-table
						    v-if="$store.state.user.role_id == 4"
						    :loading="loading"
							loading-text="Loading... Please wait"
							:headers="siteEnginerHeader"
							:items="items"
							:items-per-page="parseInt(pageInfo.per_page)"
							:server-items-length="parseInt(pageInfo.total)"
							:hide-default-footer="true"
                            :footer-props="{
								showFirstLastPage: true,
								firstIcon: 'mdi-arrow-collapse-left',
								lastIcon: 'mdi-arrow-collapse-right',
								prevIcon: 'mdi-minus',
								nextIcon: 'mdi-plus'
								}"

							class="elevation-1"
							item-key="name"
							style="width: 97%;margin-left: 2px;/* border-left: 23px; */"
							
							
							>
                            <template v-slot:item="{ item,index}"  v-if="$store.state.user.role_id == 4">
<!-- Site engineer -->
<tr v-bind:class="{'selected': item.urgent,  '': !item.urgent}" v-if="$store.state.user.role_id == 4 && pageId == item.category_id">
<td class="tds">
									
									<Button
									v-if="isUpdatePermitted"
									type="default" 
									@click="editItem(index)"
									class="button-action"
									
									>

									<Icon v-if="!item.isEditable" style="color: blue;" type="ios-create-outline" />
									<Icon v-if="item.isEditable" type="ios-document" @click="edit(item,index)" />
									<!-- {{item.isEditable ? 'save' : ''  }} -->
									
									</Button>
                                    
                                    

									<Button
									v-if="!item.isEditable && isDeletePermitted"
									type="default" 
									@click="showDeletingmodal(item,index)"
									class="button-action"
									>
									{{item.isEditable ? 'save' : '' }}
									<Icon style="color: red;" type="ios-trash" />
									</Button>
								</td>
<td   class="pt-3-half">
									<div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='approved'" id="rcorners1">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='approved'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.approved}}</div>
									</div>
									</Button>
									</div>

									 <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -59px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -25px;margin-top: -18px;">{{item.approved}}...</div>
									</div>
									</Button>
									</div>

									</td>
								<td class="pt-3-half">
									<input        
									v-model="item.itemType"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable}"
									>
									</td>
                                <td class="pt-3-half">
									<input
									style="width: 96px;"        
									v-model="item.quantity"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>
                                <td  >
									<Select v-model="item.measurenment" :disabled="!item.isEditable" :class="{'editable': item.isEditable}"
									>
										<Option :value="measure.name" :disabled="!item.isEditable" v-for="(measure, i) in measurenments" :key="i" v-if="measurenments.length">{{measure.name}}</Option>
										</Select>
									<!-- <input        
									v-model="item.measurenment"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									> -->

									</td>
									<td  class="pt-3-half"><input type="text" 
								    :readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"  v-model="item.orderReason"></td>
								 <td  >{{new Date(item.created_at).toLocaleDateString("en-US")}}</td>

   
</tr>
							</template>
 </v-data-table>


                            <v-data-table
						    v-if="$store.state.user.role_id == 1"
						    :loading="loading"
							loading-text="Loading... Please wait"
							:headers="adminHeader"
							:items="items"
							:items-per-page="parseInt(pageInfo.per_page)"
							:server-items-length="parseInt(pageInfo.total)"
							:hide-default-footer="true"
                            :footer-props="{
								showFirstLastPage: true,
								firstIcon: 'mdi-arrow-collapse-left',
								lastIcon: 'mdi-arrow-collapse-right',
								prevIcon: 'mdi-minus',
								nextIcon: 'mdi-plus'
								}"

							class="elevation-1"
							item-key="name"
							style="width: 97%;margin-left: 2px;/* border-left: 23px; */"
							
							
							>
                            <template v-slot:item="{ item,index}"  v-if="$store.state.user.role_id == 1">
								<!-- Super admin -->
							<tr v-bind:class="{'selected': item.urgent,  '': !item.urgent}" v-if="$store.state.user.role_id == 1 && pageId == item.category_id">
								<td class="tds">
									
									<Button
									v-if="isUpdatePermitted"
									type="default" 
									@click="editItem(index)"
									class="button-action"
									
									>

									<Icon v-if="!item.isEditable" style="color: blue;" type="ios-create-outline" />
									<Icon v-if="item.isEditable" type="ios-document" @click="edit(item,index)" />
									<!-- {{item.isEditable ? 'save' : ''  }} -->
									
									</Button>
                                    
                                    

									<Button
									v-if="!item.isEditable && isDeletePermitted"
									type="default" 
									@click="showDeletingmodal(item,index)"
									class="button-action"
									>
									{{item.isEditable ? 'save' : '' }}
									<Icon style="color: red;" type="ios-trash" />
									</Button>
								</td>
                                

								    <!-- <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"></td>	
                                    <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.urgent"></td>	
                                    <td class="selected" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' &&  item.urgent"><img src="/uploads/Urgent.gif" style="height: 18px;width: 18px;" v-if="item.urgent"/></td> -->
								
								
								 <td  v-show="$store.state.user.role_id == 1"  class="pt-3-half">
									 
									<div>
									<Button style="width: 91px;height: 25px;" v-if="item.status=='Completed'" id="rcorners1"        
									
									
									>
									<div style="margin-top: -5px;">
											<div style="margin-left: -83px;margin: 4p;margin-top: 1px;"><Icon style="color: white; */" v-if="item.status=='Completed'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -1px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button></div>


                                    <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.status}}...</div>
									</div>
									</Button>
									</div>



                                <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.status=='Failed'" id="rcorners3">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.status=='Failed'" type="ios-alert-outline" /></div>
											<div style="margin-right: 11px;margin-top: -18px;">{{item.status}}</div>
									</div>
									</Button>
									</div>



									</td>
								<td   class="pt-3-half">
									<div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='approved'" id="rcorners1">
									<div style="margin-top: -5px;">
									<div style="margin-left: -67px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='approved'" type="ios-checkmark-circle-outline" /></div>
											<div style="margin-right: -12px;margin-top: -18px;">{{item.approved}}</div>
									</div>
									</Button>
									</div>

									 <div>
									<Button style="width: 91px;height: 25px;"  v-if="item.approved=='Pending'" id="rcorners2">
									<div style="margin-top: -5px;">
									<div style="margin-left: -59px;margin: 4p;margin-top: 1px;">
											<Icon style="color: white; */" v-if="item.approved=='Pending'" type="ios-clock-outline" /></div>
											<div style="margin-right: -25px;margin-top: -18px;">{{item.approved}}...</div>
									</div>
									</Button>
									</div>

									</td>
								<td class="pt-3-half">
									<input        
									v-model="item.itemType"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable}"
									>
									</td>
                                <td class="pt-3-half">
									<input
									style="width: 96px;"        
									v-model="item.quantity"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>
                                <td  >
									<Select v-model="item.measurenment" :disabled="!item.isEditable" :class="{'editable': item.isEditable}"
									>
										<Option :value="measure.name" :disabled="!item.isEditable" v-for="(measure, i) in measurenments" :key="i" v-if="measurenments.length">{{measure.name}}</Option>
										</Select>
									<!-- <input        
									v-model="item.measurenment"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									> -->

									</td>
                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && item.fromStore"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Disabled</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.fromStore"><Checkbox @input="withPurchasee(item,index)" v-model="item.withPurchase"><h6></h6></Checkbox></td>
                                
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && item.withPurchase"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.withPurchase" ><Checkbox @input="frmStore(item,index)" v-model="item.fromStore"><h6></h6></Checkbox></td>

                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.withPurchase"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && item.withPurchase" ><Checkbox @input="onBought(item,index)" v-model="item.bought"><h6></h6></Checkbox></td>


                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"><input type="text" value="Need approval" style="font-size: 11px; color: red;" readonly /></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.withPurchase"><input type="text" value="Disabled" style="font-size: 11px; color: red;" readonly /></td>
                                <td v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && item.withPurchase"  class="pt-3-half" contenteditable="true">
									<input
									value="Purchased"       
									v-model="item.purchasedCompany"
									:readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"
									>
									</td>


								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'" ><input type="text" value="Need approval" style="font-size: 11px; color: red;" readonly/></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.withPurchase"><input type="text" value="Disabled" style="font-size: 11px; color: red;" readonly/></td>	
                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && item.withPurchase" @click="confirmRst(item,index)" v-bind:class="{'resetSelected': item.resetImage,  '': !item.resetImage}"><a v-if="item.resetImage"><img :src="item.resetImage" style="height: 27px;width: 32px;" v-if="item.resetImage"/></a> </td>



                                
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && (!item.withPurchase && !item.fromStore)"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds" v-show="$store.state.user.role_id == 1"  v-if="item.approved=='approved'  && (item.withPurchase || item.fromStore)" ><Checkbox @input="checkDelivered(item,index)" v-model="item.delivered"><h6></h6></Checkbox></td>


                                
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && (!item.withPurchase && !item.fromStore)"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds" v-show="$store.state.user.role_id == 1"  v-if="item.approved=='approved'  && (item.withPurchase || item.fromStore)" ><Checkbox @input="checkUnDelivered(item,index)" v-model="item.undelivered"><h6></h6></Checkbox></td>
                        
								<td  v-show="$store.state.user.role_id == 1" class="pt-3-half">
									<input type="text" :readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"  v-model="item.undeliveredReason"></td>
								<td  class="pt-3-half"><input type="text" 
								    :readonly="!item.isEditable"
									:class="{ 'editable': item.isEditable }"  v-model="item.orderReason"></td>
                                <td v-show="$store.state.user.role_id == 1" class="pt-3-half">
									<Button type="primary" style="width: 91px;"  v-if="item.adminOneApproval == 'approve'" @click="appr(item,index)">Approve</Button>
									<Button type="success"  v-if="item.adminOneApproval == 'approved'" @click="appr2(item,index)">Approved</Button>
									</td>
								<td  v-show="$store.state.user.role_id == 1" class="pt-3-half">
									<Button type="primary" style="width: 91px;" v-if="item.adminTwoApproval == 'approve'" @click="appr3(item,index)">Approve</Button>
									<Button type="success"  v-if="item.adminTwoApproval == 'approved'" @click="appr4(item,index)">Approved</Button>
									</td>


                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'"><Checkbox class="ch" onclick="return false;" style="font-size: 11px;">Need approval</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && (!item.withPurchase && !item.fromStore)"><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
								<td class="tds" v-show="$store.state.user.role_id == 1"  v-if="item.approved=='approved'  && (item.withPurchase || item.fromStore) && (item.delivered || item.undelivered) " ><Checkbox class="ch" onclick="return false;"  style="font-size: 11px;">Disabled</Checkbox></td>
                                <td class="tds" v-show="$store.state.user.role_id == 1"  v-if="item.approved=='approved'  && (item.withPurchase || item.fromStore) && (!item.delivered && !item.undelivered) " ><Checkbox @input="urgentItem(item,index)" v-model="item.urgent"><h6></h6></Checkbox></td>


                                <td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='Pending'" ></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' && !item.deliveredTime" ></td>
								<td class="tds" v-show="$store.state.user.role_id == 1" v-if="item.approved=='approved' &&  item.deliveredTime">{{new Date(item.deliveredTime).toLocaleDateString("en-US")}}<span style="font-size: 11px;"><br>{{ item.deliveredTime | moment("from","now",true) }} ago</span></td>
                                <td class="tds">{{new Date(item.created_at).toLocaleDateString("en-US")}}</td>
								
							</tr>
							</template>
							</v-data-table>
							<!-- <tr  v-if="isOnEditing">
								<td>
									
									<Button v-if="isUpdatePermitted" size="small" @click="showEditModal()">Save</Button>
												
								</td>
								<td class="pt-3-half" ><input type="text" v-model="editData.itemType"></td>
                                <td class="pt-3-half"><input type="text" v-model="editData.quantity"></td>
                                <td class="pt-3-half" ><input type="text" v-model="editData.measurenment"></td>
                                <td><Checkbox v-model="editData.withPurchase"/></td>
                                <td><Checkbox v-model="editData.fromStore"/></td>
                                <td class="pt-3-half" ><input type="text" v-model="editData.resetImage"></td>
                                <td ><input type="text"  v-model="editData.totalPrice"></td>
                                <td><input type="text"   v-model="editData.purchasedCompany"></td>
                                <td><Checkbox v-model="editData.bought"/></td>
                                <td><Checkbox v-model="editData.delivered"/></td>
                                <td class="pt-3-half"><input type="text"  v-model="editData.reason"></td>
                                <td><input type="text"  v-model="editData.result"></td>
                                <td></td>
								
							</tr> -->
								<!-- ITEMS -->

								<!-- ITEMS -->
							
								<!-- ITEMS -->


						<!-- </table> -->
						<div class="pagspace">
						   
							<Page
							:total="pageInfo.total"
							:current="pageInfo.current_page" 
							:page-size="parseInt(pageInfo.per_page)" 
							:on-next="pageInfo.next_page_url" 
							:page-size-opts="[8, 15, 20, 50, 100, 500]"
							@on-change="getPagingData" 
							v-if="pageInfo" 
							show-total
							show-sizer
							@on-page-size-change="changePageSize" 
							/>
							
						
						</div>
					</div>
				</div>
        <!-- Add modal		 -->
        <Modal
			v-model="addModal"
			title="Add Item Data"
			:mask-closable="false"
			:closable="false"
			style="font-family: Trirong, serif;">
			
            <div class="space">
			<Input type="text" v-model="data.itemType" autocomplete="name" placeholder="Item type" />
			</div>
			<div class="space">
            <Input type="text" autocomplete="name" v-model="data.quantity" placeholder="Quantity" />
            </div>
			 <div class="space">
			 <Select v-model="data.measurenment" placeholder="Select Measurenment">
                   <Option :value="measure.name" v-for="(measure, i) in measurenments" :key="i" v-if="measurenments.length">{{measure.name}}</Option>
                </Select>
            <!-- <Input type="email" autocomplete="measuernement" v-model="data.measurenment" placeholder="Measurenment" /> -->
            </div>
			<!-- <div class="space" v-if="$store.state.user.role_id == 1">
            <Checkbox v-model="data.withPurchase" v-show="$store.state.user.role_id == 1">With Purchase?</Checkbox>
            </div>
			 <div class="space" v-if="$store.state.user.role_id == 1">
            <Input type="text" autocomplete="name" v-model="data.reset" v-show="$store.state.user.role_id == 1" placeholder="Reset" />
            </div>
			<div class="space" v-if="$store.state.user.role_id == 1">
            <Input type="text" autocomplete="name" v-model="data.purchasedCompany" v-show="$store.state.user.role_id == 1" placeholder="Purchased Company" />
            </div>
			<div class="space" v-if="$store.state.user.role_id == 1">
            <Checkbox v-model="data.delivered" v-show="$store.state.user.role_id == 1">Delivered</Checkbox>
            </div>
			 <div class="space" v-if="$store.state.user.role_id == 1">
            <Checkbox v-model="data.undelivered" v-show="$store.state.user.role_id == 1">Undelivered</Checkbox>
            </div>
			<div class="space">
            <textarea  autocomplete="name" v-model="data.undeliveredReason" v-show="$store.state.user.role_id == 1" placeholder="Undelivered reason" />
            </div> -->
			<div class="space">
			<Input v-model="data.orderReason" type="textarea" autocomplete="on" :rows="4" placeholder="Write order reason..." />
            </div>
			<!-- <div class="space" v-if="$store.state.user.role_id == 1">
            <Input type="text" autocomplete="name" v-model="data.adminoneapproval" v-show="$store.state.user.role_id == 1" placeholder="Approval 1" />
            </div>
			<div class="space" v-if="$store.state.user.role_id == 1">
            <Input type="text" autocomplete="name" v-model="data.admintwoapproval" v-show="$store.state.user.role_id == 1" placeholder="Approval 2" />
            </div>
			<div class="space" v-if="$store.state.user.role_id == 1">
            <Input type="text" autocomplete="name" v-model="data.approved" v-show="$store.state.user.role_id == 1" placeholder="Approval" />
            </div> -->
			<div slot="footer">
				<Button type="default" @click="addModal=false">Close</Button>
				<!-- <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding" style="color:white">{{isAdding ? 'Adding...': 'Add Item'}}</Button> -->
				<Button type="primary" style="color:white" v-if="loading" loading>Adding...</Button>
                <Button type="primary" style="color:white" v-if="!loading" :loading="loading" @click="add">Add Item</Button>
			</div>
		</Modal>
		<!-- Edit modal -->
		 <Modal
			v-model="editModal"
			title="Edit Item"
			:mask-closable="false"
			:closable="false"
			style="font-family: Trirong, serif;">
			<Input v-model="editData.roleName" />
			<Checkbox v-model="editData.isAdmin">Is Admin?</Checkbox>
			<div slot="footer">
				<Button type="default" @click="editModal=false">Close</Button>
				<Button type="primary" @click="edit" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...': 'Edit Item'}}</Button>
			</div>
		</Modal>
              <!-- Delete alert modal -->
		<Modal :mask-closable="false"
			:closable="false" v-model="deleteBought" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <icon type="ios-information-circle"></icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Do you want remove this reset and purchased company?</p>
        </div>
        <div slot="footer">
			<Button type="default" @click="closeBgt()">Close</Button>
			<!-- <Button type="error" style="color:white" @click="deleteBgt()"> Delete</Button> -->
			<Button type="error" style="color:white" v-if="loading" loading>Deleting...</Button>
            <Button type="error" style="color:white" v-if="!loading" :loading="loading" @click="deleteBgt()">Delete</Button>
        </div>
        </Modal>
     <Modal :mask-closable="false"
			:closable="false" v-model="deleteBoughtInfo" width="360"
			style="font-family: Trirong, serif;">
        <p slot="header" style="color:#f60;text-align:center">
            <icon type="ios-information-circle"></icon>
            <span>Remove confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Do you want remove the bought information?</p>
        </div>
        <div slot="footer">
			<Button type="default" @click="closeRmvBoughtInfo()">Close</Button>
			<!-- <Button type="error" style="color:white" @click="deleteBgt()"> Delete</Button> -->
			<Button type="error" style="color:white" v-if="loading" loading>Removing...</Button>
            <Button type="error" style="color:white" v-if="!loading" :loading="loading" @click="removeBoughtInfo()">Remove</Button>
        </div>
        </Modal>

        <Modal :mask-closable="false"
			:closable="false" v-model="deleteUndelivered" width="360"
			style="font-family: Trirong, serif;">
        <p slot="header" style="color:#f60;text-align:center">
            <icon type="ios-information-circle"></icon>
            <span>Delete undelivered confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Do you want remove this undelivered reason?</p>
        </div>
        <div slot="footer">
			<Button type="default" @click="closeUndelivered()">Close</Button>
			<!-- <Button type="error" style="color:white" @click="deleteUndeliveredRsn()"> Delete</Button> -->
			<Button type="error" style="color:white" v-if="loading" loading>Deleting...</Button>
            <Button type="error" style="color:white" v-if="!loading" :loading="loading" @click="deleteUndeliveredRsn()">Delete</Button>
        </div>
        </Modal>

		<Modal v-model="resetConfirm" width="360">
        <p slot="header" style="text-align:center; font-family: Trirong, serif;">
            <!-- <icon type="ios-information-circle"></icon> -->
            <span>Reset confirmation</span>
        </p>
        <div style="text-align:center">
            <p>Do you want show or edit?</p>
        </div>
        <div slot="footer" style="text-align:center">
			<Button type="primary"   style="color:white" v-if="isUpdatePermitted && $store.state.user.role_id != 5" @click="editBgt()">Edit</Button>
            <Button type="primary"   v-if="!isUpdatePermitted && $store.state.user.role_id == 5" disabled>Edit</Button>
			<Button type="success"   style="color:white" @click="showBgt()">Show</Button>
        </div>
        </Modal>

		




       <Modal v-model="undeliveredRsn" width="360">
        <p slot="header" style="text-align:center; font-family: Trirong, serif;"
		 >
            <!-- <icon type="ios-information-circle"></icon> -->
            <span>Undelivered reason</span>
        </p>
        <div style="text-align:center">
            <Input v-model="ll.undeliveredReason" type="textarea" autocomplete="on" :rows="4" placeholder="Enter un delivered reason..." />
        </div>
        <div slot="footer" style="text-align:center">
			<!-- <Button type="success"   style="color:white" @click="saveUndeliveredRsn()">Save</Button> -->
			<Button type="success" style="color:white" v-if="loading" loading>Saving...</Button>
            <Button type="success" style="color:white" v-if="!loading" :loading="loading" @click="saveUndeliveredRsn()">Save</Button>
        </div>
        </Modal>

		<Modal :mask-closable="false"
		 :before-close="cancel"
			v-model="shwReset" width="707px" height="auto" style="height: auto; width: 623px; font-family: Trirong, serif;">
        <p slot="header" style="text-align:center">
            <!-- <icon type="ios-information-circle"></icon> -->
            <span>Reset information</span>
        </p>
        <div class="ivu-modal-content" style="text-align: center; width:675px;">
        <div style="text-align:center; width:675px;">
            <img :src= "`${ll.resetImage}`">
        </div></div>
        <div slot="footer" style="text-align:center">
			<Button type="primary" style="color:white" @click="closeShowBgt()">Close</Button>
        </div>
       
        </Modal>
		<deleteModal></deleteModal>
    <!-- Full screen modal -->
		<Modal v-model="viewInfoModal" fullscreen title="Role Info" style="font-family: Trirong, serif;">
               <p>Role Name: {{viewData.roleName}}</p>
			   <p>Created at: {{viewData.created_at}}</p>
			   <div slot="footer">
				<Button type="default" @click="viewInfoModal=false">Close</Button>
			</div>
        </Modal>
		<Modal
			v-model="imageModal"
			title="Add bought information"
			:mask-closable="false"
			:closable="false"
			style="font-family: Trirong, serif;">
            
			<Input autocomplete="on" v-model="singleItem.purchasedCompany" type="text" placeholder="Purchased company name" />
            <!-- <div class="space" style="padding: 8px;"></div> -->
			 <div class="space" style="padding: 8px;"></div>
			
            <Upload
			  v-show="!singleItem.resetImage"
			  ref="reset" 
              type="drag"
			  :headers="{'x-csrf-token' :token,'X-Requested-With':'XMLHttpRequest'}"
			  :on-success="handleSuccess"
              :format="['jpg','jpeg','png']"
			  :on-format-error="handleFormatError"
              :max-size="2048"
              :on-error="handleError"
              :on-exceeded-size="handleMaxSize"
              action="/app/upload/reset/photo">
            <div style="padding: 20px 0">
               <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                <p>Click or drag files here to upload</p>
            </div>
            </Upload>
			<div class="demo-upload-list" v-if="singleItem.resetImage">
            
                <img :src= "`/uploads/Reset photos/${singleItem.resetImage}`">
            <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click="deleteImage()"></Icon>
            </div>
               
            </div>
           
			
               
            
			<!-- <div class="image_thumb" v-if="data.iconImage">
				 <img :src = "`/uploads/${data.iconImage}`" style="width: 26%;" />
			</div> -->
			<div slot="footer">
				<Button type="default" @click="onClosingImage()">Close</Button>
				<!-- <Button type="primary" @click="addReset()" :disabled="isAdding" :loading="isAdding" style="color:aliceblue;">{{isAdding ? 'Saving...': 'Save'}}</Button> -->
				<Button type="primary" style="color:aliceblue;" v-if="loading" loading>Saving...</Button>
                <Button type="primary" style="color:aliceblue;" v-if="!loading" :loading="loading" @click="addReset()">Save</Button>
			</div>
		</Modal>
		 <Modal
			v-model="editReset"
			title="Edit reset"
			:mask-closable="false"
			:closable="false"
			style="font-family: Trirong, serif;">
			<Input type="text" autocomplete="on" v-model="itm.purchasedCompany" placeholder="Purchased Company Name" />
            <div class="space" style="padding: 8px;"></div>
			
            <Upload
			  v-show="isIconImageNew && !itm.resetImage"
			  ref="resetEdit" 
              type="drag"
			  :headers="{'x-csrf-token' :token,'X-Requested-With':'XMLHttpRequest'}"
			  :on-success="handleSuccess"
              :format="['jpg','jpeg','png']"
			  :on-format-error="handleFormatError"
              :max-size="2048"
              :on-error="handleError"
              :on-exceeded-size="handleMaxSize"
              action="/app/upload/reset/photo">
            <div style="padding: 20px 0" >
               <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                <p>Click or drag files here to upload</p>
            </div>
            </Upload>
			<div class="demo-upload-list" v-if="itm.resetImage">
               
                <img :src= "`${itm.resetImage}`">
            <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
            </div>
               
            </div>
			<div slot="footer">
				<Button type="default" @click="onClosingImage(false)">Close</Button>
				<!-- <Button type="primary" @click="editResetFile()" :disabled="isEditing" :loading="isEditing" style="color:aliceblue;">{{isEditing ? 'Editing...': 'Edit reset'}}</Button> -->
				<Button type="primary" style="color:aliceblue;" v-if="loading" loading>Editing...</Button>
                <Button type="primary" style="color:aliceblue;" v-if="!loading" :loading="loading" @click="editResetFile()">Edit reset</Button>
			</div>
		</Modal>
		<!-- <Modal
			v-model="deleteBought"
			width="360">
		<p slot="header" style="color:#f60;text-align:center">
			<Icon type="ios-information-circle"></Icon>
			<span>Delete confirmation</span>
		</p>
		<div style="text-align:center">
			<p>Do you want delete the reset and purchased company Name?</p>
			
		</div>
		<div slot="footer">
			<Button type="error" size="large" long : loading="showDeleteModal" :disabled="showDeleteModal"  @click="deleteBgt()">Delete</Button>
		</div>
		</Modal> -->
			</div>
		</div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';
import deleteModal from '../components/deleteModal.vue';
 // import the component
import Treeselect from '@riophae/vue-treeselect'
  // import the styles
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
export default{
	components: { Treeselect },components: { Treeselect },
     data(){
		 return{
			adminHeader: [
					{
						text: 'Action',
						align: 'start',
						filterable: false,
						value: 'action',
						sortable: false,
					},
					{ text: 'Status', value: 'status',sortable: false},
					{ text: 'Approval', value: 'approved',sortable: false},
					{ text: 'Item Type', value:'itemType',sortable: false },
					{ text: 'Quantity', value: 'quantity',sortable: false },
					{ text: 'Measurnmet', value: 'measurnment',sortable: false },
					{ text: 'With Purchase', value: 'withPurchase',sortable: false },
					{ text: 'From Store', value: 'fromStore',sortable: false },
					{ text: 'Purchased', value: 'bought',sortable: false },
					{ text: 'Purchased Company', value: 'purchasedCompany',sortable: false },
					{ text: 'Reset', value: 'reset',sortable: false },
					{ text: 'Delivered', value: 'delivered',sortable: false },
					{ text: 'Undelivered', value: 'undelivered',sortable: false },
					{ text: 'Undelivered Reason', value: 'undeliveredReason' ,sortable: false},
					{ text: 'Order Reason', value: 'orderReason',sortable: false },
					{ text: 'Approval 1', value: 'adminOneReason',sortable: false },
					{ text: 'Approval 2', value: 'adminTwoApproval',sortable: false },
					{ text: 'Urgent', value: 'urgent' ,sortable: false},
					{ text: 'Delivered Time', value: 'deliveredTime' ,sortable: false},
					{ text: 'Created Date', value: 'createdAt',sortable: false },
				
           ],
		   mainStoreKeeperHeader: [
					{
						text: 'Action',
						align: 'start',
						filterable: false,
						value: 'action',
						sortable: false
					},
					{ text: 'Status', value: 'status' ,sortable: false},
					{ text: 'Approval', value: 'approved',sortable: false },
					{ text: 'Item Type', value:'itemType',sortable: false },
					{ text: 'Quantity', value: 'quantity' ,sortable: false},
					{ text: 'Measurnmet', value: 'measurnment',sortable: false },
					{ text: 'With Purchase', value: 'withPurchase',sortable: false },
					{ text: 'From Store', value: 'fromStore' ,sortable: false},
					{ text: 'Created Date', value: 'createdAt',sortable: false },
				
           ],
		   siteEnginerHeader: [
					{
						text: 'Action',
						align: 'start',
						filterable: false,
						value: 'action',
						sortable: false
					},
					{ text: 'Approval', value: 'approved',sortable: false },
					{ text: 'Item Type', value:'itemType' ,sortable: false},
					{ text: 'Quantity', value: 'quantity',sortable: false },
					{ text: 'Measurnmet', value: 'measurnment',sortable: false },
					{ text: 'Order Reason', value: 'orderReason',sortable: false },
					{ text: 'Created Date', value: 'createdAt',sortable: false },
				
           ],
		   storeKeeperTwoHeader: [
					{
						text: 'Action',
						align: 'start',
						filterable: false,
						value: 'action',
						width: '103%',
						sortable: false
					},
					{ text: 'Status', value: 'status',sortable: false },
					{ text: 'Approval', value: 'approved',sortable: false },
					{ text: 'Item Type', value:'itemType',sortable: false },
					{ text: 'Quantity', value: 'quantity',sortable: false },
					{ text: 'Measurnmet', value: 'measurnment',sortable: false },
					{ text: 'From Store', value: 'fromStore',sortable: false},
					{ text: 'Purchased', value: 'bought',sortable: false },
					{ text: 'Purchased Company', value: 'purchasedCompany',sortable: false },
					{ text: 'Reset', value: 'reset' ,sortable: false},
					{ text: 'Delivered', value: 'delivered',sortable: false },
					{ text: 'Undelivered', value: 'undelivered',sortable: false },
					{ text: 'Undelivered Reason', value: 'undeliveredReason' ,sortable: false},
					{ text: 'Delivered Time', value: 'deliveredTime',sortable: false },
					{ text: 'Created Date', value: 'createdAt',sortable: false },
				
           ],
		  purchaserHeader: [
					{
						text: 'Action',
						align: 'start',
						filterable: false,
						value: 'action',
						sortable: false
					},
					{ text: 'Status', value: 'status',sortable: false },
					{ text: 'Approval', value: 'approved' ,sortable: false},
					{ text: 'Item Type', value:'itemType' ,sortable: false},
					{ text: 'Quantity', value: 'quantity' ,sortable: false},
					{ text: 'Measurnmet', value: 'measurnment' ,sortable: false},
					{ text: 'With Purchase', value: 'withPurchase',sortable: false },
					{ text: 'Bought', value: 'bought',sortable: false },
					{ text: 'Purchased Company', value: 'purchasedCompany' ,sortable: false},
					{ text: 'Reset', value: 'reset' ,sortable: false},
					{ text: 'Created Date', value: 'createdAt' ,sortable: false},
				
           ],
			data : {
				itemType:'',
                measurenment:'',
				withPurchase:false,
				delivered:false,
				undelivered:false,
				bought:false,
				fromStore:false,
				urgent:false,
				message:'',
				toUserId:'',
			    status:'',
				route:'',
				total: 8,
			},
			value: null,
        // define options
        options: [ {
				id: 'a',
				label: 'a',
				children: [ {
					id: 'aa',
					label: 'aa',
				}, {
					id: 'ab',
					label: 'ab',
				} ],
				}, {
				id: 'b',
				label: 'b',
				}, {
				id: 'c',
				label: 'c',
				} ],
			dat: {
				title: 'Status',
                        expand: true,
                        value: 'status',
                        selected: false,
                        checked: false,
                        children: [
                            {
                                title: 'pending',
                                value: 'delivered',
                                selected: false,
                                checked: false,
                            },
							{
                                title: 'delivered',
                                value: 'delivered',
                                selected: false,
                                checked: false,
                            },
							{
                                title: 'failed',
                                value: 'delivered',
                                selected: false,
                                checked: false,
                            },
                            {
                                title: 'Approval',
                                expand: true,
                                value: 'approval',
                                selected: false,
                                checked: false,
                                children: [
                                   {
                                title: 'pending',
                                value: 'delivered',
                                selected: false,
                                checked: false,
                            },
							{
                                title: 'delivered',
                                value: 'delivered',
                                selected: false,
                                checked: false,
                            },
                                ]
                            }
                        ]
			},
			itm:{
		      purchasedCompany:'',
              resetImage:'',
			  total: 8
			},
			notiff:{
				message:'',
				toUserId:'',
			    status:'',
				route:''
			},
			isListing:true,
			isOnEditing: false,
			editModal: false,
			addModal : false,
			isAdding : false,
			items : [],
			projects : {},
			permissions : [],
			measurenments : [
				{"name": "Kg"},
				{"name": "Galon"},
				{"name": "Litre"}
			],
			editData: {
				id:'',
				itemType:'',
                measurenment:'',
				withPurchase:false,
				delivered:false,
				undelivered:false,
				bought:false,
				fromStore:false,
				urgent:false,
				message:'',
				toUserId:'',
			    status:'',
			},
			viewData:{},
			index : -1,
			showDeleteModal: false,
			isDeleting:false,
			deleteItm:{},
			deletingIndex:-1,
			viewInfoModal:false,
			spinShow: true,
			total: 8,
			pageInfo:null,
			projectName:'',
			imageModal:false,
			token:'',
			isOnEditing:false,
			img:'',
			singleItem:{total: 8},
			itmobj:{total: 8},
			deleteBought:false,
			resetConfirm:false,
			ll:{total: 8},
			shwReset:false,
			editReset:false,
			isIconImageNew:false,
			isAdd:false,
			undeliveredRsn:false,
			deleteUndelivered:false,
			timestamp:'',
			isEditing:false,
			loading:false,
			approvedItems:[],
			withPurchasedItems:[],
			frmStoreItems:[],
			deleteBoughtInfo:false,
			pageId:0,
			paging:false,
			str:'',
			currentUserId:0
			// value: '',
		 }
	 },
	 methods : {
		async add(){
		  this.data.requestUserId = this.$store.state.user.id
		  this.data.requestUserName = this.$store.state.user.fullName
		  this.data.isEditable = ''
		  let catId = parseInt(this.$route.params.id)
		  console.log('The category id is',catId)
		  this.data.category_id = catId
		  this.data.adminOneApproval = "approve"
		  this.data.adminTwoApproval = "approve"
		  
		 
			this.data.status = "Pending"
			this.data.approved ="Pending"
			if(this.data.itemType.trim()=='' || this.data.itemType == '') return this.error('Item type is required')
			if(this.data.measurenment.trim()=='' || this.data.measurenment == '') return this.error('Measurenment is required')
			if(this.data.orderReason.trim()=='' || this.data.orderReason == '') return this.error('Order reason is required') 
		this.loading = true
		let  notification = {
				message:this.$store.state.user.fullName+" "+"has ordered"+" "+ this.data.itemType +" "+ "item at"+" "+this.projectName,
				toUserId:this.projects.requestUserId,
				status:"Pending",
				route:this.$route.fullPath,
				project_id:catId
			}
			this.notiff = notification
			
			const res= await this.callApi('post','/app/create-inventorydata',this.data)
			if(res.status=== 200 || res.status === 201){
				this.items.unshift(res.data)
				this.getRoleData()
				this.success('Item has been registered successfully!')
				this.addModal = false
				this.data.itemType = ''
				this.data.quantity = ''
				this.data.measurenment = ''
				this.data.orderReason=''
			}else{
				if(res.status==422){
					if(res.data.error.itemType){
						this.error(res.data.error.roleName[0])
					}
					console.log(res.data.error.roleName)
				}else{
					
					this.swr()
				}
				
			}
			if(this.$store.state.user.role_id != 1){
						const notif= await this.callApi('post','/app/create-notification',notification)
						if(notif.status == 200){
								console.log("Success notify",notif.data.notification)
								this.$store.commit('setNotification',notif.data.notification)
							}
						}
            this.loading = false
		
		
		//   console.log("The error",notif.status)
		 },
		async editResetFile(){
			this.itm.total = this.total
			this.loading = true
			const res = await this.callApi('put','/app/update/inventory_data',this.itm)
			  if(res.status==200){
				  this.getRoleData()
				  this.success('Rest has been edited')
			    }else{
					this.error("Error occured")
				}
				this.editReset = false
				this.resetConfirm = false
				this.loading = false
		},
		async urgentItem(item,i){
			item.total= this.total
			if(item.urgent && (item.status == 'Completed' || item.status =='Failed')){
			  item.urgent = false
			  this.error("Sorry, The item status is" + " " + item.status)
			  this.getRoleData()
			}else if(!item.urgent && (item.status == 'Completed' || item.status =='Failed')){
			  return ''
			}else{
			  const res = await this.callApi('put','/app/update/inventory_data',item)
			  if(res.status==200){
				  if(item.urgent){
				  this.success('This item has been set to urgent')
				  if(item.adminOneApproval == true && item.adminTwoApproval == true && !item.delivered || !item.undelivered){
                     let  notification = {
						message:"The"+" "+item.itemType+" "+"item"+" "+"has been set to urgent from"+" "+this.projectName,
						status:"Pending",
						route:this.$route.fullPath,
						project_id:item.category_id,
						role_id:3
					}
					await this.callApi('post','/app/create-notification',notification)
				  }if(item.withPurchase){
                    let  notification = {
						message:"The"+" "+item.itemType+" "+"item"+" "+"has been set to urgent from"+" "+this.projectName,
						status:"Pending",
						route:this.$route.fullPath,
						project_id:item.category_id,
						role_id:2
					}
					await this.callApi('post','/app/create-notification',notification)
				  }if(item.bought == true || item.fromStore == true){
                    let  notification = {
						message:"The"+" "+item.itemType+" "+"item"+" "+"has been set to urgent from"+" "+this.projectName,
						status:"Pending",
						route:this.$route.fullPath,
						project_id:item.category_id,
						role_id:5
					}
					await this.callApi('post','/app/create-notification',notification)
				  }
				//   this.getRoleData()
				  }
				console.log("Hi")
			    }else{
					this.error("Error occured")
				}}
				
		},
		getNow: function() {
                    const today = new Date();
                    const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    const dateTime = date +' '+ time;
                    this.timestamp = dateTime;
                },
		async checkDelivered(item,i){
			item.total = this.total
            if(item.delivered){
				    item.urgent = false
					item.deliveredTime = new Date()
					item.status = 'Completed'
					if(item.undelivered){
						item.undelivered = false
						item.undeliveredReason = ''
					}
			    const res =	await this.callApi('put','/app/update/inventory_data',item)
				if(res.status==200){
					this.getRoleData()
					let  notification = {
						message:"The"+" "+item.itemType+" "+"item"+" "+"has been delivered from"+" "+this.projectName,
						toUserId:this.projects.requestUserId,
						status:"Pending",
						route:this.$route.fullPath,
						project_id:item.category_id,
						role_id:1
					}
					if(this.$store.state.user.role_id != 1){
					await this.callApi('post','/app/create-notification',notification)}
					this.success('Congratulations item order has been successfully delivered!!!')
					}else{
						this.error('Something went to wrong')
					}
				}else{
					item.deliveredTime = ''
					item.status = 'Pending'
					await this.callApi('put','/app/update/inventory_data',item)	
					if(res.status==200){
					this.success('Congratulations item order has been successfully delivered!!!')
					}else{
						this.error('Something went to wrong')
					}
				}
			// }else{
			// 	this.error('Something went to wrong')
			// }
		},
		async checkUnDelivered(item,index){
			 item.total = this.total
			 let obj = {
				id:item.id,
				itemType:item.itemType,
				quantity:item.quantity,
                measurenment:item.measurenment,
				category_id:item.category_id,
                requestUserId:item.requestUserId,
				orderReason:item.orderReason,
                withPurchase:item.withPurchase,
                bought:item.bought,
				resetImage:item.resetImage,
				purchasedCompany:item.purchasedCompany,
				delivered:item.delivered,
				undelivered:item.undelivered,
				undeliveredReason:item.undeliveredReason,
				fromStore:item.fromStore,
				status:item.status,
				urgent:item.urgent,
				adminOneApproval:item.adminOneApproval,
				adminTwoApproval:item.adminTwoApproval,
				approved:item.approved,
				total: this.total
			}
			this.ll = obj
			item.deliveredTime = ''
			let  notification = {
						message:"The"+" "+item.itemType+" "+"item"+" "+"has been undelivered from"+" "+this.projectName,
						toUserId:this.projects.requestUserId,
						status:"Pending",
						route:this.$route.fullPath,
						project_id:item.category_id,
						role_id:1
					}
			if(item.undelivered){
			item.undelivered = true}
            const res = await this.callApi('put','/app/update/inventory_data',item)
            if(res.status === 200){
				if(item.undelivered){
					if(item.delivered){
						item.delivered = false
						item.status = 'Failed'
						await this.callApi('put','/app/update/inventory_data',item)
					if(this.$store.state.user.role_id != 1){	
					await this.callApi('post','/app/create-notification',notification)}
					
					}
					this.undeliveredRsn = true
					item.status = 'Failed'
					item.urgent = false
					await this.callApi('put','/app/update/inventory_data',item)
					if(this.$store.state.user.role_id != 1){
					await this.callApi('post','/app/create-notification',notification)}
				}else{
						if(!item.undelivered && item.undeliveredReason){
							this.itm = item
							this.itm.undelivered = true
							this.deleteUndelivered = true
							await this.callApi('put','/app/update/inventory_data',this.itm)
							console.log('Hereeee 1', this.itm.status)
						}else if(!item.undelivered  && !item.undeliveredReason){
							item.status = 'Pending'
							this.itm = item
                            await this.callApi('put','/app/update/inventory_data',item)
							console.log('Hereeee 2', this.itm.status)
						}
				}
			}else{
				this.error('Something went to wrong')
			}
		},
		async saveUndeliveredRsn(){
			this.loading = true
			this.ll.status = 'Failed'
			this.ll.delivered = false
			this.ll.urgent = false
			this.ll.total = this.total
            const res = await this.callApi('put','/app/update/inventory_data',this.ll)
            if(res.status === 200){
			   this.getRoleData()
               this.undeliveredRsn = false
			}
			this.loading = false
		},
		closeShowBgt(){
			this.resetConfirm = false
            this.shwReset = false
		},
		closeUndelivered(){
			this.deleteUndelivered = false
            this.itm.undelivered = true
		},
		async deleteUndeliveredRsn(){
			this.loading = true
			this.itm.undelivered = false
			this.itm.undeliveredReason = ''
			this.itm.status = 'Pending'
			this.itm.total = this.total
			this.deleteUndelivered = false
		    await this.callApi('put','/app/update/inventory_data', this.itm)
			this.loading = false
			// this.getRoleData()
		},
		confirmRst(item,i){
			 let obj = {
				id:item.id,
				itemType:item.itemType,
				quantity:item.quantity,
                measurenment:item.measurenment,
				category_id:item.category_id,
                requestUserId:item.requestUserId,
				orderReason:item.orderReason,
                withPurchase:item.withPurchase,
                bought:item.bought,
				resetImage:item.resetImage,
				purchasedCompany:item.purchasedCompany,
				delivered:item.delivered,
				undelivered:item.undelivered,
				undeliveredReason:item.undeliveredReason,
				fromStore:item.fromStore,
				status:item.status,
				urgent:item.urgent,
				adminOneApproval:item.adminOneApproval,
				adminTwoApproval:item.adminTwoApproval,
				approved:item.approved,
				total: this.total
			}
			this.singleItem = item
			this.isIconImageNew = true
			this.itm = item
			this.ll = item
			this.itm = obj
			this.resetConfirm = true
		},
        async addReset(){
			this.loading=true
			this.singleItem.total = this.total
			if(this.singleItem.purchasedCompany==null && this.singleItem.resetImage == null){
				this.loading=false
				return this.error('Please add purchased company name or reset image')
			}
			if(this.singleItem.resetImage){
			  this.singleItem.resetImage = `/uploads/Reset photos/${this.singleItem.resetImage}`}
              const res = await this.callApi('put','/app/update/inventory_data',this.singleItem)
			  if(res.status==200){
				  this.getRoleData()
				  if(this.singleItem.resetImage){
				  this.success('Rest has been added')
				   
				  
				  }}
				  this.success('Purchased company has been resgistered')
				  this.imageModal = false
				  this.isAdd = false
				  this.singleItem.purchasedCompany = ''
			      this.singleItem.resetImage = ''
				  this.$refs.reset.clearFiles()
			this.loading=false
		},
        async edit(item,index){
          this.editData.total = this.total
          let obj = {
				id:item.id,
				itemType:item.itemType,
				quantity:item.quantity,
                measurenment:item.measurenment,
				category_id:item.category_id,
                requestUserId:item.requestUserId,
				orderReason:item.orderReason,
                withPurchase:item.withPurchase,
                bought:item.bought,
				resetImage:item.resetImage,
				purchasedCompany:item.purchasedCompany,
				delivered:item.delivered,
				undelivered:item.undelivered,
				undeliveredReason:item.undeliveredReason,
				fromStore:item.fromStore,
				status:item.status,
				urgent:item.urgent,
				adminOneApproval:item.adminOneApproval,
				adminTwoApproval:item.adminTwoApproval,
				approved:item.approved,
				total: this.total
			}
		    this.editData = obj
			this.index = index
          if(this.editData.itemType.trim()=='' || this.editData.itemType == '') return this.error('Item type is required')
		  console.log('The edited',this.editData.id)
		  const res = await this.callApi('put','/app/update/inventory_data',this.editData)
	      if(res.status===200){
		    //   this.items[this.index].roleName = this.editData.roleName
			//   this.roles[this.index].isAdmin = this.editData.isAdmin
              this.success('Item has been edited successfully!')
			//   this.editModal = false
			  //this.data.roleName = ''
		  }else{
	        if(res.status==422){
				if(res.data.errors.roleName){
					this.error(res.data.errors.roleName[0])
				}
                 console.log(res.data.errors.roleName)
			}else{
				
				this.swr()
			}
			  
		  }
		 },
		async frmStore(item,i){
		      let obj = {
				id:item.id,
				itemType:item.itemType,
				quantity:item.quantity,
                measurenment:item.measurenment,
				category_id:item.category_id,
                requestUserId:item.requestUserId,
				orderReason:item.orderReason,
                withPurchase:item.withPurchase,
                bought:item.bought,
				resetImage:item.resetImage,
				purchasedCompany:item.purchasedCompany,
				delivered:item.delivered,
				undelivered:item.undelivered,
				undeliveredReason:item.undeliveredReason,
				fromStore:item.fromStore,
				status:item.status,
				urgent:item.urgent,
				adminOneApproval:item.adminOneApproval,
				adminTwoApproval:item.adminTwoApproval,
				approved:item.approved,
				total: this.total
			}
              const res = await this.callApi('put','/app/update/inventory_data', obj)
			  if(res.status===200){
				this.projectName = this.$route.params.projectName
				let  notification = {
						message:"The"+" "+item.itemType+" "+"item"+" "+"has been set to store at"+" "+this.projectName,
						role_id:5,
						status:"Pending",
						route:this.$route.fullPath,
						project_id:item.category_id
					}
					if(this.$store.state.user.role_id != 1){
					const notif = await this.callApi('post','/app/create-notification',notification)}
				}else{
					this.swr()
				}
		},
		async onBought(item,i){
		this.isAdd = true
		this.singleItem = {
			    id:item.id,
				itemType:item.itemType,
                measurenment:item.measurenment,
				quantity:item.quantity,
                withPurchase:item.withPurchase,
                fromStore:item.fromStore,
				singlePrice:item.singlePrice,
				totalPrice:item.totalPrice,
				purchasedCompany:item.purchasedCompany,
				bought:item.bought,
				resetImage:item.resetImage,
				delivered:item.delivered,
				undelivered:item.undelivered,
				undeliveredReason:item.undeliveredReason,
				orderReason:item.orderReason,
		        adminOneApproval:item.adminOneApproval,
				adminTwoApproval:item.adminTwoApproval,
				urgent:item.urgent,
				deliveredTime:item.deliveredTime,
				status:item.status,
				approved:item.approved,
				requestUserId:item.requestUserId,
				category_id:item.category_id,
				total: this.total
		}
		
		const res = await this.callApi('put','/app/update/inventory_data',this.singleItem)
			if(res.status===200){
				let  notification = {
						message:"The"+" "+item.itemType+" "+"item"+" "+"has been bought from"+" "+this.projectName,
						status:"Pending",
						route:this.$route.fullPath,
						project_id:item.category_id,
						role_id:5
					}
					if(this.$store.state.user.role_id != 1){
					await this.callApi('post','/app/create-notification',notification)}
				//   this.roles[this.index].isAdmin = this.editData.isAdmin
				//this.getRoleData()
				// this.success('Item has been edited successfully!')
				
				//   this.editModal = false
				//this.data.roleName = ''
			}
	    if(item.bought && (!item.purchasedCompany && !item.resetImage)){
           this.imageModal = true
		}else if(!item.bought && item.purchasedCompany || item.resetImage){
		   this.ll =item
		   this.deleteBought = true
		}

		},
		async closeBgt(){
		   if(this.ll.purchasedCompany || this.ll.resetImage){ 
			   this.ll.bought = true
			   this.ll.total = this.total
			   const res = await this.callApi('put','/app/update/inventory_data',this.ll)
				if(res.status===200){
					this.deleteBought = false
					//   this.roles[this.index].isAdmin = this.editData.isAdmin
					//this.getRoleData()
					//this.success('Item has been edited successfully!')
					
					//   this.editModal = false
					//this.data.roleName = ''
				}
		   }
			
		   
		},
		closeRmvBoughtInfo(){
            this.ll.withPurchase = true
			this.deleteBoughtInfo = false
		},
		async removeBoughtInfo(){
			this.loading = true
            this.ll.withPurchase = false
			this.ll.bought = false
			this.ll.purchasedCompany = ''
			this.ll.resetImage = ''
			this.ll.total = this.total
			const res = await this.callApi('put','/app/update/inventory_data', this.ll)
			if(res.status==200){
               this.success('Congra')
			}else{
               this.swr()
			}
			this.loading = false
			this.deleteBoughtInfo = false
		},
		// async deleteBgt(){
        //    this.singleItem.purchasedCompany=''
		//    this.singleItem.resetImage=''
		//    const res = await this.callApi('put','/app/update/inventory_data',this.singleItem)
		// 	if(res.status===200){
		// 		//   this.items[this.index].roleName = this.editData.roleName
		// 		//   this.roles[this.index].isAdmin = this.editData.isAdmin
		// 		this.getRoleData()
		// 		this.success('Item has been edited successfully!')
		// 		this.deleteBought = false
		// 		//   this.editModal = false
		// 		//this.data.roleName = ''
		// 	}
			
		   
		// },
		editBgt(){
			this.editReset =true
			this.isAdd = false
			this.isOnEditing=true
		},
		
		async deleteBgt(){
		   this.loading = true
           this.singleItem.purchasedCompany=''
		   this.singleItem.resetImage=''
		   this.singleItem.total = this.total
		   const res = await this.callApi('put','/app/update/inventory_data',this.singleItem)
			if(res.status===200){
				//   this.items[this.index].roleName = this.editData.roleName
				//   this.roles[this.index].isAdmin = this.editData.isAdmin
				this.getRoleData()
				this.success('Item has been edited successfully!')
				this.deleteBought = false
				//   this.editModal = false
				//this.data.roleName = ''
			}
			this.loading = false
		   
		},
	    cancel(){
           this.resetConfirm = false
		},
		showBgt(){
           this.shwReset = true
		},
		withPur(){
			   this.error('First, approve this project!!!')
			   return false
		},
		async withPurchasee(item,i){
		   item.total = this.total
		   this.ll = item
           if(item.withPurchase){
		
			const res = await this.callApi('put','/app/update/inventory_data',item)
			if(res.status === 200){
            this.projectName = this.$route.params.projectName
			let  notification = {
					message:"The"+" "+item.itemType+" "+"item"+" "+"has been set to purchase at"+" "+this.projectName,
					role_id:2,
					status:"Pending",
					route:this.$route.fullPath,
					project_id:item.category_id
				}
				if(this.$store.state.user.role_id != 1){
				const notif = await this.callApi('post','/app/create-notification',notification)
					if(notif.status===200 || 201){
					//   this.items[this.index].roleName = this.editData.roleName
					//   this.roles[this.index].isAdmin = this.editData.isAdmin
					this.success('Item has been set to purchase')}
					else{
						this.error('There is error')
					}		 
				}
			
			}	
			
			
		}else if(!item.withPurchase) {
		  if(item.bought || item.purchasedCompany || item.resetImage){
              this.deleteBoughtInfo = true	
		  }else{
			  console.log("Heyyy")
              await this.callApi('put','/app/update/inventory_data',item)
		  }
		  }
		
		},
		async deleteImage(isAdd=true){
			if(!isAdd){ // for editing.....
			    // this.editData.iconImage=''
			    // this.$refs.clearFiles()
				
                this.isIconImageNew=true
				this.img = this.itm.resetImage
			    this.$refs.resetEdit.clearFiles()
			}else{
			this.$refs.reset.clearFiles() 
			this.img = this.singleItem.resetImage
			// this.itm.resetImage=''
			
			}
			const res = await this.callApi('post','/app/delete_image',{resetImage:this.img})
			if(res.status==200){
				this.singleItem.resetImage=''
				this.itm.resetImage=''
			}
			// this.isIconImageNew=true
			if (res.status!=200){
               this.data.iconImage = this.img
			   this.swr()
			}
			
		},
		async appr(item,i){
			 item.total = this.total
             item.adminOneApproval = 'approved'
			 
				// item.total = this.total
				const res = await this.callApi('put','/app/update/inventory_data',item)
					if(res.status===200){
					//   this.items[this.index].roleName = this.editData.roleName
					//   this.roles[this.index].isAdmin = this.editData.isAdmin
					if(item.adminOneApproval == 'approved' && item.adminTwoApproval == 'approved'){
				       item.approved = 'approved'
					   await this.callApi('put','/app/update/inventory_data',item)
							if(this.$store.state.user.role_id != 2 && this.$store.state.user.role_id != 3
								&& this.$store.state.user.role_id != 4 && this.$store.state.user.role_id != 5){
								if(item.requestUserId != this.$store.state.user.id){
									this.currentUserId = item.requestUserId	
									// console.log('The notification user id', this.currentUserId)
								}
								let  notification1 = {
									message:"Your ordered"+" "+item.itemType+" "+"item"+" "+"has been approved",
									toUserId:this.currentUserId,
									status:"Pending",
									route:this.$route.fullPath,
									project_id:item.category_id,
									role_id:4
								}
								let  notification2 = {
									message:"The"+" "+item.itemType+" "+"item"+" "+"has been approved at" + " " + this.projectName,
									status:"Pending",
									route:this.$route.fullPath,
									project_id:item.category_id,
									role_id:3
								}
								let notifArray = [notification1,notification2]
								
								if(item.requestUserId != this.$store.state.user.id){
								await this.callApi('post','/app/create-notification', notification1)
								}
								await this.callApi('post','/app/create-notification', notification2)}
							
							    this.success('Item has been approved successfully!')
								}
				
				//  window.Echo.channel('notification.'+this.$store.state.user.id).listen('ItemAdded',(e) =>{
							
				// 			console.log("The socket is here",e)

				// 	})
			 }
		},
		async appr2(item,i){
			item.total = this.total
            item.adminOneApproval = 'approve'
			item.approved ='Pending'
			// item.total = this.total
			 const res = await this.callApi('put','/app/update/inventory_data',item)
	         if(res.status===200){
		    //   this.items[this.index].roleName = this.editData.roleName
			//   this.roles[this.index].isAdmin = this.editData.isAdmin
            //   this.success('Item has been unapproved successfully!')
			}
		},
		async appr3(item,i){ 
			 item.total = this.total
             item.adminTwoApproval = 'approved'
			//  item.total = this.total
			 const res = await this.callApi('put','/app/update/inventory_data',item)
					if(res.status===200){
					//   this.items[this.index].roleName = this.editData.roleName
					//   this.roles[this.index].isAdmin = this.editData.isAdmin
					if(item.adminOneApproval == 'approved' && item.adminTwoApproval == 'approved'){
				       item.approved = 'approved'
							await this.callApi('put','/app/update/inventory_data',item)
							if(this.$store.state.user.role_id != 2 && this.$store.state.user.role_id != 3
								&& this.$store.state.user.role_id != 4 && this.$store.state.user.role_id != 5){
								if(item.requestUserId != this.$store.state.user.id){
									this.currentUserId = item.requestUserId
									// console.log('The notification user id', this.currentUserId)
								}
								let  notification1 = {
									message:"Your ordered"+" "+item.itemType+" "+"item"+" "+"has been approved",
									toUserId:this.currentUserId,
									status:"Pending",
									route:this.$route.fullPath,
									project_id:item.category_id,
									role_id:4
								}
								let  notification2 = {
									message:"The"+" "+item.itemType+" "+"item"+" "+"has been approved at" + " " + this.projectName,
									status:"Pending",
									route:this.$route.fullPath,
									project_id:item.category_id,
									role_id:3
								}
								let notifArray = [notification1,notification2]
								if(item.requestUserId != this.$store.state.user.id){
								await this.callApi('post','/app/create-notification', notification1)
								}
								await this.callApi('post','/app/create-notification', notification2)}
								
							    this.success('Item has been approved successfully!')
								}
				
				//  window.Echo.channel('notification.'+this.$store.state.user.id).listen('ItemAdded',(e) =>{
							
				// 			console.log("The socket is here",e)

				// 	})
			 }
		},
		async appr4(item,i){
			 item.total = this.total
             item.adminTwoApproval = 'approve'
			 item.approved ='Pending'
			//  item.total = this.total
			 const res = await this.callApi('put','/app/update/inventory_data',item)
	         if(res.status===200){
		    //   this.items[this.index].roleName = this.editData.roleName
			//   this.roles[this.index].isAdmin = this.editData.isAdmin
            //   this.success('Item has been unapproved successfully!')
			}
		},
		showEditModal(item,index){
			this.isListing=false
			this.isOnEditing=true
			let obj = {
				id:item.id,
				itemType:item.itemType,
                measurenment:item.measurenment,
				quantity:item.quantity,
                withPurchase:item.withPurchase,
                fromStore:item.fromStore,
				singlePrice:item.singlePrice,
				totalPrice:item.totalPrice,
				purchasedCompany:item.purchasedCompany,
				bought:item.bought,
				delivered:item.delivered,
				reason:item.reason,
				result:item.result
			}
		    this.editData = obj
			this.items.index = index
	     },
		 onClosingImage(isAdd=true){
		   //this.isIconImageNew=false
		   if(!isAdd){
			 this.isOnEditing=false
			 this.isIconImageNew=false
			 this.editReset=false
			 this.$refs.resetEdit.clearFiles()
			 this.isEditing=false
			 this.resetConfirm=false
		   }else{
		  
		   
		   this.singleItem.purchasedCompany=''
		   this.imageModal=false
		   if (this.singleItem.resetImage){
		       this.deleteImage()
		  
		   }
		  
		   }
		},
		handleSuccess (res, file) {
			if(this.isOnEditing){
				this.itm.resetImage = `/uploads/Reset photos/${res}`
				console.log(this.itm.resetImage)
			}else{
				
			    //  console.log("Here")
				//  this.$store.commit('setPhoto',res)
				//  console.log("Success photo", this.$store.state.photo)
				 
			     this.singleItem.resetImage = res
				 console.log(this.singleItem.resetImage)
                //console.log(this.data.photo)
				//  if(this.data.photo != res){
				// 	 this.data.photo = res
				//  }
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
		// async deleteTag(){
        //     this.isDeleting =true
		// 	const res = await this.callApi('delete','app/delete_tag',this.deleteItem)
		// 	if(res.status==200){
		// 	    this.tags.splice(this.deletingIndex,1)
		// 		this.success('Tag has been deleted successfully!!!')
		// 	}else{
		// 		this.swr()
		// 	}
		// 	this.isDeleting = false
		// 	this.showDeleteModal = false
		// },
		showDeletingmodal(item,i){
			const deleteModalObj = {
            showDeleteModal: true,
            deleteUrl: '/app/delete/inventory_data',
            data: item,
            deletingIndex: i,
            isDeleted: false,
			msg: 'Are you sure delete this item?',
			successmsg:'Item has been deleted successfully!!!'
        }
		this.$store.commit('setDeletingModalObj',deleteModalObj)
		console.log('Item is on deleting')
			// this.deleteItem = tag
			// this.deletingIndex=i
			// this.showDeleteModal = true
            // if(!confirm('')) return
            // //tag.isDeleting = true
			// this.$set(tag,'isDeleting',true)
		},
		viewInfo(role){
			this.viewInfoModal =true
			let obj = {
				id:role.id,
				roleName:role.roleName,
				created_at:role.created_at
			}
		    this.viewData = obj


		},
		editItem (index) {
			if(this.$store.state.user.role_id == 2){
                this.withPurchasedItems[index].isEditable = !this.withPurchasedItems[index].isEditable
			}
			else if(this.$store.state.user.role_id == 3){
                this.approvedItems[index].isEditable = !this.approvedItems[index].isEditable
			}else if(this.$store.state.user.role_id == 5){
                this.frmStoreItems[index].isEditable = !this.frmStoreItems[index].isEditable
				console.log("Hey Kaleb")
			}else{
                this.items[index].isEditable = !this.items[index].isEditable
			}
        },
		async searchInventoryData(page=1){
                    const project_id = parseInt(this.$route.params.id)
					const res = await this.callApi('get',`/app/search_inventory?str=${this.str}&page=${page}&total=${this.total}&project_id=${project_id}`);
					
					if(res.status===200){
						if(this.$store.state.user.role_id == 2){
								this.withPurchasedItems = res.data.data.map(item => ({ isEditable: false, ...item }))
								this.pageInfo = res.data;
							}else if(this.$store.state.user.role_id == 3){
								 
										this.approvedItems = res.data.data.map(item => ({ isEditable: false, ...item }))
								        this.pageInfo=res.data;   
											
											
								
						    }else if(this.$store.state.user.role_id == 5){
								this.frmStoreItems = res.data.data.map(item => ({ isEditable: false, ...item }))
								this.pageInfo=res.data;
						    }else{
								this.items = res.data.data.map(item => ({ isEditable: false, ...item }))
								this.pageInfo=res.data}
							}else{
								this.swr()
							}
					},
		changePageSize(page){
						//s page size
						if(!this.str){
							this.pageInfo.index = 1;
							this.total = page;
							this.getPagingData(page=1);
						}else{
							this.pageInfo.index = 1;
							this.total = page;
							this.searchInventoryData()
						}
						
					},
		async getRoleData(page = 1){
			console.log('The router',this.$route)
			if(this.$store.state.user.category_id !=  parseInt(this.$route.params.id) 
			&& this.$store.state.user.role_id != 1
			 && this.$store.state.user.role_id != 2 && this.$store.state.user.role_id != 3 && this.$store.state.user.role_id != 5){
                   this.$router.push("notfound")
			}
			this.permissions = this.$store.state.permissions
            const id = parseInt(this.$route.params.id)
			this.projectName = this.$route.params.projectName
			console.log('Project Name',this.projectName)
            console.log('The id',id)
            if(id<1 || !id){
            this.$router.push('/notfound')
            }
    
			const res = await this.callApi('get',`/app/paginate/inventory_data/project/${id}?page=${page}&total=${this.total}`);
		    const resTwo = await this.callApi('get',`/app/paginate/approved/inventory_data/project/${id}?page=${page}&total=${this.total}`);
            const resThree = await this.callApi('get',`/app/paginate/with_purchase/inventory_data/project/${id}?page=${page}&total=${this.total}`);
			const resFour = await this.callApi('get',`/app/paginate/store_kepper/two/inventory_data/project/${id}?page=${page}&total=${this.total}`);

			const pro = await this.callApi('get',`/app/project/${id}`);
            this.projects = pro.data[0]
			console.log("The data", this.projects.projectName)
		    console.log(res.data)
			if(res.status===200 || 201){
				if(this.$store.state.user.role_id == 2){
					this.withPurchasedItems = resThree.data.data.map(item => ({ isEditable: false, ...item }))
					this.pageInfo=resThree.data
					this.spinShow= false
				}
				else if(this.$store.state.user.role_id == 3){
					this.approvedItems = resTwo.data.data.map(item => ({ isEditable: false, ...item }))
					this.pageInfo=resTwo.data
					this.spinShow= false
			   }else if(this.$store.state.user.role_id == 5){
					this.frmStoreItems = resFour.data.data.map(item => ({ isEditable: false, ...item }))
					this.pageInfo=resFour.data
					this.spinShow= false
					// console.log('Bla bla bla', this.frmStoreItems)
			   }else{
					this.items = res.data.data.map(item => ({ isEditable: false, ...item }))
					//this.items = res.data.data
					this.spinShow= false
					this.pageInfo=res.data}
			}else{
				this.swr()
			}
		},
		async getPagingData(page=1){
			this.paging = true
			const id = parseInt(this.$route.params.id)
			this.projectName = this.$route.params.projectName
			console.log('Project Name',this.projectName)
            console.log('The id',id)
            if(id<1 || !id){
            this.$router.push('/notfound')
            }
    
			const res = await this.callApi('get',`/app/paginate/inventory_data/project/${id}?page=${page}&total=${this.total}`);
		    const resTwo = await this.callApi('get',`/app/paginate/approved/inventory_data/project/${id}?page=${page}&total=${this.total}`);
            const resThree = await this.callApi('get',`/app/paginate/with_purchase/inventory_data/project/${id}?page=${page}&total=${this.total}`);
			const resFour = await this.callApi('get',`/app/paginate/store_kepper/two/inventory_data/project/${id}?page=${page}&total=${this.total}`);

			const pro = await this.callApi('get',`/app/project/${id}`);
            this.projects = pro.data[0]
			console.log("The data", this.projects.projectName)
		    console.log(res.data)
			if(res.status===200 || 201){
				if(this.$store.state.user.role_id == 2){
					this.withPurchasedItems = resThree.data.data.map(item => ({ isEditable: false, ...item }))
					this.pageInfo=resThree.data
					this.spinShow= false
				}
				else if(this.$store.state.user.role_id == 3){
					this.approvedItems = resTwo.data.data.map(item => ({ isEditable: false, ...item }))
					this.pageInfo=resTwo.data
					this.spinShow= false
			   }else if(this.$store.state.user.role_id == 5){
				   console.log('The response', resFour.status)
					this.frmStoreItems = resFour.data.data.map(item => ({ isEditable: false, ...item }))
					this.pageInfo=resFour.data
					this.spinShow= false
			   }else{
					this.items = res.data.data.map(item => ({ isEditable: false, ...item }))
					//this.items = res.data.data
					this.spinShow= false
					this.pageInfo=res.data}
			}else{
				this.swr()
			}
			// this.paging = false
		}
	 },
	 async created(){
          this.pageId = this.$route.params.id
		  this.token=window.Laravel.csrfToken
		  this.getRoleData()
		  this.getPagingData()
		  this.searchInventoryData()
		},
	components:{
        deleteModal,
	 },
	 computed:{
       ...mapGetters(['getDeleteModalObj'])
	 },
	 watch : {
       getDeleteModalObj(obj){
	      console.log(obj)
		  console.log(obj.isDeleted)
		  if(obj.isDeleted){
			  this.items.splice(obj.deletingIndex,1)
			  this.getRoleData()
			  obj.isDeleted = false
		  }
	   }
	 },
mounted() {
	
	if(this.$store.state.user.role_id == 2){
	
	 window.Echo.channel('withpurchaseinvent')
     .listen('WithPurchase',(e) =>{
         console.log("The 2nd socket is here", e)
		  e.invent.data.forEach(inv=>{
					if(parseInt(this.$route.params.id)==inv.category_id){
						this.withPurchasedItems = e.invent.data.map(item => ({ isEditable: false, ...item }))
						this.pageInfo = e.invent}})
		//  this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
		//  this.pageInfo= e.invent
    })}
	else if(this.$store.state.user.role_id == 3){
	
	 window.Echo.channel('maininvent')
     .listen('MainStore',(e) =>{
         console.log("The 2nd socket is here", e)
		  e.invent.data.forEach(inv=>{
					if(parseInt(this.$route.params.id)==inv.category_id){
		 this.approvedItems = e.invent.data.map(item => ({ isEditable: false, ...item }))
		 this.pageInfo = e.invent}})
		//  this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
		//  this.pageInfo= e.invent
    })}
	else if(this.$store.state.user.role_id == 5){
	
	 window.Echo.channel('storetwoinvent')
     .listen('StoreTwo',(e) =>{
         console.log("The 2nd socket is here", e)
		  e.invent.data.forEach(inv=>{
					if(parseInt(this.$route.params.id)==inv.category_id){
		 this.frmStoreItems = e.invent.data.map(item => ({ isEditable: false, ...item }))
		 this.pageInfo = e.invent}})
		//  this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
		//  this.pageInfo= e.invent
    })}else if(this.$store.state.user.role_id == 1 || this.$store.state.user.role_id == 4) {
	   console.log('Where is the debug')
	//    window.Echo.channel('invent')
    //      .listen('ItemAdded',(e) =>{
    //      console.log("The socket is here plus", e.invent)
    //     e.invent.data.forEach(inv=>{
	// 		console.log('Socket project id',parseInt(this.$route.params.id))
	// 				if(parseInt(this.$route.params.id)==inv.category_id){
	// 					console.log('Here is going',inv.category_id)
	// 					this.items = e.invent.data.map(item => ({ isEditable: false, ...item }))
	// 					this.pageInfo= e.invent}})
    // });
	}else{
		return
	}
},
//    async created(){
// 	   const res = await this.callApi('post','/app/create_tag',{tagName:'testertag'});
	  
// 	   if(res.status==200){
// 		  // console.log(res)
// 	   }else{
// 		   console.log(res)
// 		   console.log('running')
// 	   }
//    }
}
</script>
<style>
.ch{
    font-size: 11px;
	color:red;
}
tr.selected {
    -webkit-animation: pulse-border 1s infinite;
}
.resetSelected{
	background-color: rgb(209, 209, 209);
}
/* Select:disabled {
  color: red;
} */
/* tr.left {
    border-right: 12px dashed black;
} */
@-webkit-keyframes pulse-border {
    from, to { box-shadow: 0 0 0 0 #f5a6a68c;}
    50% { box-shadow: 0 0 0 4px #f5a6a68c;background:#f5a6a68c}
}
.tds {
	min-width:141px
}
</style>