<template>
    <div class="content">
        <div class="form-card">
            <form @submit="update">
                <div class="title-card">
                    <h2>Edit Product</h2>
                </div>
                <div class="body-card">
                    <div v-if="errors.length > 0" class="error-message">
                        <ul class="error-list">
                            <li v-for="(error,index) in errors" :key="index">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div v-if="success.trim() !== ''" class="success-message">
                        {{ success }}
                    </div>
                    <span v-if="!item" class="loading">Loading...</span>
                    <div v-else>
                        <div class="form-input">
                            <span>Name</span>
                            <input name="product" type="text" v-model="item.name">
                        </div>
                        <div class="form-input">
                            <span>Description</span>
                            <vue-trix v-model="item.description" placeholder="Description" name="description" />
                        </div>
                        <div class="form-input">
                            <span>Category</span>
                            <select v-model="item.category" name="category">
                                <option :style="{'text-transform':'capitalize'}">music</option>
                                <option :style="{'text-transform':'capitalize'}">gaming</option>
                                <option :style="{'text-transform':'capitalize'}">peripherals</option>
                                <option :style="{'text-transform':'capitalize'}">accesories</option>
                                <option :style="{'text-transform':'capitalize'}">hardware</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="button-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from '../../../axios';
import { getToken } from '../../../Utilities/Helpers'
import VueTrix from "vue-trix"

export default {
    components:{
        'vue-trix': VueTrix,
    },
    data:() => {
        return {
            product_id: "",
            itemLoaded: false,
            success: "",
            item: {},
            errors: [],
        }
    },
    methods: {

        update(e){
            e.preventDefault();

            let data = {
                name: this.item.name,
                description: this.item.description,
                category: this.item.category,
            };

            this.errors = [];
            this.success = '';
            if(this.item.name.trim() === '')
            {
                this.errors.push('Name is required');
            }

            if(this.item.description.trim() === '')
            {
                this.errors.push('Description is required');
            }

            if(this.item.category.trim() === '')
            {
                this.errors.push('Category is required');
            }

            if(this.errors.length <= 0)
            {
                axios.patch(`product/${this.product_id}`,data,{
                    headers: {
                        'Authorization': `Bearer ${getToken()}`,
                },
                })
                .then(res => {
                    if(res.status == 200 && res.data.status){
                        this.success = "Successfully Updated";
                    }
                })
                .catch(err => {
                    this.errors.push('Something went wrong');
                });
            }
        }
    },
    created(){
        const token = localStorage.getItem('token');
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

        this.product_id = this.$router.history.current.params.id;
        axios.get(`product/${this.product_id}/edit`,{
            headers:{
                "Authorization": `Bearer ${token}`,
            }
        })
        .then(res => {
            if(res.data.status && res.status == 200){
                this.item = res.data.product;
            }
            this.itemLoaded = true;
        })
        .catch(err => console.log(err));
    }
}
</script>

<style>
    button.submit{
        background-color: rgba(9, 114, 6, 0.76);
        color: white;
    }

    .loading{
        margin: auto;
        margin-top: 2rem;
        font-size: 30px;
        font-weight: 600;
        color: black;
    }

    .success-message{
        width: 100%;
        background-color: #28a745;
        padding: 1rem;
        color:white;
        display:flex;
        flex-flow: column;
        border-radius: 5px;
        text-align: center;
    }
</style>