<template>
    <div class="sidebar">
        <ul class="menu">
            <li>
                <a @click="activeClass" href="#">Products</a>
                <ul>
                    <li>
                        <router-link to="/product/list">
                            List
                        </router-link>
                    </li>
                    <li><router-link to="/product/create">Create</router-link></li>
                </ul>
            </li>
            <li><router-link :to="{name:'videos-link'}">Videos Link</router-link></li>
        </ul>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            productsActive: false,
        }
    },
    methods:{
        activeClass(e){
            let sub_menu = e.target.nextElementSibling;
            this.productsActive = !this.productsActive;
            sub_menu.classList.toggle('is-active');
        },
    },
}
</script>

<style scoped>
    .sidebar{
        height: 100vh;
        width: 15vw;
        background-color: #343a40;
        user-select: none;
        position: fixed;
    }

    .sidebar > ul{
        height: 100%;
        margin-top: 4rem;
        list-style: none;
        width: 100%;
    }

    .sidebar ul li {
        color: white;
        letter-spacing: 2px;
        line-height: 2rem;
        width: 100%;
        border-bottom: none;
        font-size: 24px;
        cursor: pointer;
    }

    .sidebar ul li a {
        text-decoration: none;
        padding: 10px 0px 10px 15px;
        color: white;
        box-sizing: border-box;
        font-size: 18px;
        transition: all .5s;
        width: 100%;
        display: block;
    }
    .sidebar ul li a:hover {
       background: #007bff;
    }

    .sidebar ul ul {
        position: static;
        list-style: none;
        max-height: 0px;
        overflow: hidden;
        box-sizing: border-box;
        transition: all .5s;
    }

    .sidebar ul ul li {
        border-bottom: none;
        line-height: 1.5rem;
        width: 100%;
        box-sizing: border-box;
    }

    .sidebar ul ul li a {
        text-decoration: none;
        padding: 10px 0px 10px 45px;
        color: white;
        box-sizing: border-box;
        font-size: 15px;
        transition: all .5s;
        widows: 100%;
        display: block;
    }

    .is-active {
        max-height: 6rem !important;
        overflow: visible !important;
    }
    
    .active {
        background: #007bff;
    }
    
</style>