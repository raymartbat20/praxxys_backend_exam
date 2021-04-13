<template>
    <div class="nav-header">
        <h1>Backend Exam</h1>
        <button class="logout-button" @click="logout">Logout</button>
    </div>
</template>

<script>
export default {
    methods:{
        logout(){
            localStorage.removeItem('token');
            this.$router.push('/');
        }
    }
}
</script>

<style scoped>
 .nav-header{
     position: fixed;
     height: 7vh;
     width: 85vw;
     background-color: #ffffff;
     display: flex;
     border-bottom: 1px solid #dee2e6;
     align-items: center;
     justify-content: space-between;
     padding: 5px 15px;
     margin-left: 15vw;
 }

.logout-button{
    background-color: #343a40;
    user-select: none;
    color:white;
    font-size: 16px;
    font-weight: 600;
}

.nav-header h1{
    color: #343a40;
}

</style>