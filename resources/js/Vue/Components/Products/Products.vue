<template>
    <div class="content">
        <div v-if="itemDeleted.trim() !== ''" class="success-message mb-5">
            {{ itemDeleted }}
        </div>
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Product List</h1>
                <div>
                    <select v-model="category" @change="filterCategory">
                        <option>Consumable</option>
                        <option>Music</option>
                        <option>Gaming</option>
                        <option>Peripherals</option>
                        <option>Accessories</option>
                        <option>Hardware</option>
                    </select>
                </div>
                <div class="search">
                    <form @submit="filterData">
                        <input class="input-search" placeholder="Search" v-model="search" />
                        <button class="button-primary button-search" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td colspan="4"><span class="loading">Loading...</span></td>
                        </tr>
                        <tr v-else-if="!loading && items.length <= 0">
                            <td colspan="4"><span class="loading">No Data Found</span></td>
                        </tr>
                        <tr v-else v-for="(item,key) in items" :key="key">
                            <td>{{item.name}}</td>
                            <td v-html="item.description"></td>
                            <td>{{item.category}}</td>
                            <td>
                                <router-link :to="{name:'product-edit',params:{id:item.id}}" tag="button" class="edit-button">
                                    <font-awesome-icon icon="eye" />
                                </router-link>
                                <button class="delete-button" @click="deleteProduct(item.id)">
                                    <font-awesome-icon icon="trash"/>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="pagination">
                    <pagination v-for="link in links"
                    :key="link.label"
                    v-bind:label="link.label"
                    v-bind:active="link.active"
                    v-bind:link="link.url"
                    v-on:changePage="changePage"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from '../../../axios'
import { getToken} from '../../../Utilities/Helpers'
import Paginate from '../Paginate.vue'

export default {
    components: {
        'pagination': Paginate,
    },
    data:() => {
        return {
            search: "",
            currentPage: "",
            links: [],
            pages: {},
            items : [],
            last_page: "",
            category: "",
            loading: true,
            itemDeleted: '',
        }
    },
    methods:{
        changePage(link){
            this.loading = true;
            axios.get(`${link}`,{
                headers:{
                    'Authorization': `Bearer ${getToken()}`,
                }
            })
            .then(res => {
                if(res.data.status && res.status == 200){
                this.items = res.data.products.data;
                this.links = res.data.products.links;
                this.currentPage = res.data.products.current_page;
                this.lastPage = res.data.products.last_page;
                }
                this.loading = false;
            })
            .catch(err => console.log(err));
        },
        filterData(e){
            this.loading = true;
            e.preventDefault();
            let link = this.category ? `product?search=${this.search}&category=${this.category}` : `product?search=${this.search}`
            axios.get(link,{
                headers:{
                    'Authorization': `Bearer ${getToken()}`,
                }
            })
            .then(res => {
                if(res.data.status && res.status == 200){
                    this.items = res.data.products.data;
                    this.links = res.data.products.links;
                    this.currentPage = res.data.products.current_page;
                    this.lastPage = res.data.products.last_page;
                }
                    this.loading = false;
            })
            .catch(err => console.log(err))
        },
        filterCategory(){
            this.loading = true;
            let link = this.search ? `product?search=${this.search}&category=${this.category}` : `product?category=${this.category}`
            axios.get(link,{
                headers:{
                    'Authorization': `Bearer ${getToken()}`,
                }
            })
            .then(res => {
                if(res.data.status && res.status == 200){
                    this.items = res.data.products.data;
                    this.links = res.data.products.links;
                    this.currentPage = res.data.products.current_page;
                    this.lastPage = res.data.products.last_page;
                }
                    this.loading = false;
            })
            .catch(err => console.log(err))
        },
        deleteProduct(product_id){
            if(confirm("Delete this product?")){
                axios.delete(`product/${product_id}`,{
                    headers:{
                        'Authorization': `Bearer ${getToken()}`,
                    }
                })
                .then(res => {
                    if(res.status == 200 && res.data.status){
                        this.itemDeleted = "Item deleted";
                        this.getList();
                    } else {
                        this.errors.push('Something Went Wrong');
                    }
                })
                .catch(err => console.log(err))
            }
        },
        getList(){
            axios.get(`product`,{
                        headers:{
                            "Authorization": `Bearer ${getToken()}`
                }
            }).then(res => {
                if(res.data.status && res.status == 200){
                    this.loading = false;
                    this.items = res.data.products.data;
                    this.links = res.data.products.links;
                    this.currentPage = res.data.products.current_page;
                    this.lastPage = res.data.products.last_page;
                }
            })
        }
    },
    created(){
        const token = localStorage.getItem('token');
        if(token){
            axios.get('http://localhost:8000/api/check-token',{
                headers:{
                    "Authorization": `Bearer ${token}`,
                    "Accept": 'application/json',
                    "Content-type": 'application/json',
                }
            })
            .then(response => {
                if(!response.status === 200){
                    router.push('/');
                    localStorage.removeItem('token');
                }
            })
            .catch(err => {
                if(err.response.status === 401)
                {
                    this.$router.push('/')
                }
            });
        }

        this.getList();
    },
}
</script>

<style>
 table{
     width: inherit;
     border-radius: 5px;
     border-collapse: collapse;
 }

table thead tr th{
    background-color: white;
    box-sizing: border-box;
    padding: 5px;
    color: black;
    border: 1px solid #cecfcf;
    font-size: 20px;
    font-weight: 100;
}

 table tbody tr td {
    text-align: center;
    padding: 10px;
    font-weight: bold;
    font-weight: bold;
    font-size: 16px;
    border: 1px solid #cecfcf;
 }

 table tbody tr td ul{
     list-style:none;
 }

 .delete-button{
     background-color:red;
     color:white;
     padding: 5px 10px;
}

.edit-button{
    background-color: rgb(230, 197, 16);
    color: white;
    padding: 5px 10px;
}

.pagination{
    margin-top: 5px;
    display:flex;
    width: 100%;
    flex-direction: row;
    justify-content: flex-end;
}

.search{
    display: flex;
    justify-content: flex-end;
    margin-bottom: 5px;
    color: grey;
}

.search input{
    width: 15rem;
    color: grey;
}

.card{
    width: 83vw;
    overflow: visible;
    border: .5px solid #cecfcf;
    border-radius: 5px;
    background-color: white;
}

.card-header{
    border-bottom: 1px solid #cecfcf;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
    padding: 1rem;
    align-items: center;
}
.card-header .card-title{
    font-size: 20px;
    color:black;
    font-weight: 100;
}

.card .card-body{
    padding: 1rem;
    width: 100%;
}

.card .card-footer{
    background-color: #f7f7f7;
    padding: 1rem;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
}

.input-search{
    font-size: 20px;
    padding: 5px;
}

.button-search{
    padding: 5px 10px;
    font-size: 20px;
    font-weight: 100;
}
</style>