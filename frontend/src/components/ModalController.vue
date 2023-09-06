<template lang="">
    <div class="modal__container" v-if="isOpenModal" @click="closeModel">
        <div class="modal" >
            <h2 class="modal__header">{{title}}</h2>
            <p class="modal__notifi">
                {{content}}
            </p>
            <div class="modal__btn">
                <button class="btn modal__btn--cancel" @click="closeModel">Cancel</button>
                <button class="btn modal__btn--accept" @click="handleDelete">Sure</button>
            </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    content: {
        type: String,
        required: true,
    },
    isOpenModal: {
        type: Boolean
    },
    closeModel: {
        type: Function
    },
    handleDelete: {
        type: Function
    }
})

</script>
<style lang="css">
.modal__container {
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    transition-timing-function: ease-in-out;

}

.modal {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translate(-50%, 0);
    z-index: 2;
    margin: 0 auto;
    background-color: white;
    width: 400px;
    padding: 5px;
    height: auto;
    border-radius: 10px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    transition-timing-function: ease-in-out;


}

.modal .modal__header {
    display: flex;
    justify-content: center;
    font-size: 25px;
    padding-bottom: 10px;
    color: #E8B63F;
    border-bottom: 1px solid #ccc;
}


.modal .modal__btn {
    display: flex;
    justify-content: flex-end;
    padding: 20px;
}

.modal__btn .btn {
    width: 80px;
    height: 30px;
    margin-left: 10px;
    cursor: pointer;
    background-color: white;
    color: black;
    border-radius: 5px;
    outline: none;
    border: 1px solid #ccc
}

.modal__btn .modal__btn--accept {
    background-color: green;
    color: white;
}

.modal__btn .modal__btn--cancel {
    background-color: red;
    color: white;
}
</style>


