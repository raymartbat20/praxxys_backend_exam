<template>
    <div class="login" :class="auth ? 'd-none' : ''">
        <form @submit="formSubmit">
            <div class="login-form">
                <div class="error-message" :class="failedLogin ? '' : 'd-none'">{{ failedLogin }}</div>
                <h1>Login Form</h1>
                <input placeholder="username" type="text" v-model="username" class="input username" autocomplete="false" />
                <input placeholder="password" type="password" v-model="password" class="input" autocomplete="false" />
                <button class="button button-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Login",
    data: () => {
        return {
            auth: true,
            username: "",
            password: "",
            failedLogin: "",
        }
    },
    methods:{
        formSubmit(e){
            e.preventDefault();
            const data = {
                username: this.username,
                password: this.password,
            };
            axios.post('http://localhost:8000/api/login',data,{
                'Accept': 'application/json',
                'Content-type': 'application/json',
            })
            .then(response => {
                console.log(response);
                if(response.data.status && response.data.user){
                    localStorage.setItem('token',response.data.token);
                    this.$router.push('/dashboard');
                } else {
                    this.failedLogin = response.data.message;
                    this.password = "";
                }
            })
            .catch(err => {
                console.log(err);
                this.failedLogin = "Something went wrong";
            })
        }
    },
    created(){
        let token = localStorage.getItem('token');
        axios.get('http://localhost:8000/api/check-token',{
            headers:{
                "Authorization": `Bearer ${token}`,
                "Accept": 'application/json',
                "Content-type": 'application/json',
            }
        })
        .then(response => {
            if(response.status === 200){
                this.$router.push('/dashboard');
            }
        })
        .catch(err => this.auth = false);
    },
}
</script>

<style scoped>
    h1 {
        font-size: 36px;
        font-weight: bold;
        color: black;
        position: relative;
        top: -3rem;
    }

    .login{
        display:flex;
        justify-content: center;
        background: #e3e3e3;
        align-items: center;
        width: 100%;
        height: 100vh;
    }

    .login-form{
        background: white;
        color: black;
        border-radius: 5px;
        height: 50vh;
        width: 25vw;
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: center;
    }

    input{
        margin-bottom: 5px;
    }

    .error-message{
        width: 75%;
        padding: 10px 10px;
        font-size: 16px;
        color: white;
        background-color: #f02d2dd8;
        font-weight: 600;
        position: relative;
        top: -3.5rem;
        border-radius: 5px;
        border: 1px solid #ff8080f5;
        text-align: center;
    }

    .d-none {
        display: none;
    }
</style>