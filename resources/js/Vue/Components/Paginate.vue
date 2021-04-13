<template>
    <div class="paginate" :class="active ? 'active' : ''" @click="$emit('changePage',link )">
        <span class="paginate-label">{{ labelParser(label) }}</span>
    </div>
</template>


<script>
export default {
    props:['label','active','clickFunction','link'],
    methods: {
        labelParser(label){
            const parser = new DOMParser();
            return parser.parseFromString(label,'text/html').body.textContent;
        },
    }
}
</script>

<style scoped>
    .paginate{
        background:white;
        border: 1px solid rgb(57, 188, 240);
        color: rgb(57, 188, 240);
        user-select: none;
        cursor: pointer;
    }

    .paginate-label {
        display: block;
        font-size: 15px;
        padding: 8px;
        text-align: center;
    }

    .active{
        background-color: rgb(57, 188, 240);
        color: white;
    }
</style>