<template>
    <div class="content">
        <form class="form-card" @submit="submitForm">
            <div class="title-card">
                <h2>Create Product Form</h2>
            </div>
            <div class="body-card">
                <div v-if="errors.length > 0" class="error-message">
                    <ul class="error-list">
                        <li v-for="(error,index) in errors" :key="index">
                            {{ error }}
                        </li>
                    </ul>
                </div>
                <div class="form-input">
                    <span>Name</span>
                    <input name="product_name" v-model="input.name" type="text" placeholder="Name" />
                </div>
                <div class="form-input">
                    <span>Category</span>
                    <select v-model="input.category" name="category">
                        <option disabled value="">Please select a category</option>
                        <option>Music</option>
                        <option>Gaming</option>
                        <option>Peripherals</option>
                        <option>Accesories</option>
                        <option>Hardware</option>
                    </select>
                </div>
                <div class="form-input">
                    <span>Description</span>
                    <vue-trix v-model="input.description" placeholder="Description" name="description" />
                </div>
                <div class="form-input">
                    <span>Image Upload</span>
                    <image-upload
                    @before-remove="beforeRemove"
                    @upload-success="uploadImageSuccess"
                    browseText="Click to browse"
                    dropText="drop image"
                    dragText="Drag Text"
                    primaryText="Uploaded"
                    >
                    </image-upload>
                </div>
                <div class="form-input">
                    <span>Date Time Picker</span>
                    <datetime-picker format="YYYY-MM-DD h:i:s" v-model="input.dateTime" />
                </div>  
            </div>
            <div class="card-footer">
                <button type="submit" class="button-primary">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from '../../../axios'
import defaultAxios from 'axios'
import VueTrix from "vue-trix"
import VueUploadMultipleImage from 'vue-upload-multiple-image'
import datetime from 'vuejs-datetimepicker'
import { getToken } from '../../../Utilities/Helpers'

export default {
    components:{
        'vue-trix': VueTrix,
        'image-upload': VueUploadMultipleImage,
        'datetime-picker': datetime,
    },
    data:() => {
        return {
            input:{
                name: "",
                category: '',
                description: "",
                dateTime: '',
                images: [],
            },
            errors: [],
        }
    },
    methods:{
        beforeRemove (index, done, fileList) {
            console.log('index', index, fileList)
            var r = confirm("Are you sure you want to remove the image?")
            if (r == true) {
                done()
            }
        },
        uploadImageSuccess(formData, index, fileList){
            // Upload image api
            defaultAxios.post('http://localhost:8000/api/image-upload', formData,{
                headers:{
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                this.input.images.push(response.data.name)
            })
        },
        submitForm(e){
            e.preventDefault();
            this.errors = [];
            if(this.input.name.trim() === '')
            {
                this.errors.push('Name is required');
            }

            if(this.input.description.trim() === '')
            {
                this.errors.push('Description is required');
            }

            if(this.input.category.trim() === '')
            {
                this.errors.push('Category is required');
            }

            if(this.input.dateTime.trim() === '')
            {
                this.errors.push('Datetime is required');
            }

            if(this.input.images.length <= 0)
            {
                this.errors.push('Images is required');
            }
            
            if(this.errors.length <= 0){
                const data = this.input;
                defaultAxios.post('http://localhost:8000/api/product',data,{
                    headers:{
                        'Authorization': `Bearer ${getToken()}`,
                    }
                })
                .then(res => {
                    this.$router.push('/product/list')
                })
                .catch(err => console.log(err))
            }
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
    }
}
</script>

<style>
    .form-card{
        z-index: 9999;
        border: 1px solid grey;
        border-radius: 5px;
        display: flex;
        flex-flow: column;
        width: 83vw;
    }

    .title-card{
        background-color: royalblue;
        border-top: 5px;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        color: white;
    }

    .body-card{
        margin-top: 15px;
        padding: 10px 20px;
    }

    .body-card input, .body-card select{
        width: 100%;
        background-color: white;
        padding: 10px 15px;
    }

    .form-input span{
        color: black;
        font-weight: bold;
        font-size: 18px;
    }

    .form-input{
        margin: 10px 0px;
    }

    .form input{
        width: 100%;
        margin-bottom: 0.5rem;
        color: black;
        font-size: 16px;
        margin-top: 8px;
    }


    .form-input select{
        border-radius: 5px;
        width: 100%;
        margin-bottom: 0.5rem;
        color: black;
        font-size: 18px;
        margin-top: 8px;
    }
    .form-card .card-footer{
        padding: 1rem;
        background-color: rgb(244, 246, 249);
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .error-message{
        width: 100%;
        background-color: #dc3545;
        padding: 1rem;
        color:white;
        display:flex;
        flex-flow: column;
        border-radius: 5px;
        text-align: left;
    }

    .error-message ul {
        margin-left: 8px;
    }
</style>