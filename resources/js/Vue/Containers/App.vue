<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "App",
    data: function() {
        return {
            auth: true,
            message:"Welcome to laravel vue",
        }
    },
    methods:{
        authenticated() {
            this.auth = false;
            alert("sad");
            if (this.auth){
                alert("Authenticated");
            }
        }
    }
}
</script>

<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: sans-serif;
}

input {
    padding: 15px 20px;
    font-size: 16px;
    width: 75%;
    color: black;
    border: 1px solid grey;
    border-radius: 5px;
    outline: none;
}

select {
    padding: 10px;
    font-size: 16px;
    width: 100%;
    color: black;
    border: 1px solid grey;
    border-radius: 5px;
    outline: none;
}

button {
    border: none;
    padding: 15px 25px;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
    cursor: pointer;
}

button:active{
    outline: none;
    border: none;
}

.button-primary{
    background-color: rgb(41, 61, 248);
    color: white;
    /* border: 3px solid rgba(74, 168, 223, 0.911); */
}

.d-none{
    display: none;
}

.content {
    position: fixed;
    margin-left: 15vw;
    padding: 1em;
    height: 93vh;
    overflow: auto;
    margin-top: 7vh;
    /* background-color: #f4f6f9; */
    margin-bottom: 25px;
}

.mb-5{
    margin-bottom: 5px;
}
</style>
