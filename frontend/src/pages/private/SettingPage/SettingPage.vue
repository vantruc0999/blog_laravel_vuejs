<template >
    <div class="setting__container">
        <div class="setting__controller">
            <router-link to="/setting/account" class="setting__route">
                Tài khoản
            </router-link>
            <!-- <router-link to="/setting/account">
            Seri
        </router-link> -->
            <router-link to="/setting/ban" class="setting__route">
                Đã chặn
            </router-link>
        </div>
        <router-view></router-view>
    </div>
</template>
<script setup>

</script>
<style lang="scss" scoped>
.setting__container {
    padding: 0 140px;
    display: flex;
    margin-top: 120px;

    .setting__controller {
        display: flex;
        flex-direction: column;
        margin-right: 150px;
        color: var(--black-color);
        gap: 18px;
        font-weight: 400;

        .setting__route {
            padding-left: 10px;

            &:hover {
                color: var(--primary-color);
            }

        }
    }
}

.router-link-exact-active {
    border-left: 4px solid var(--primary-color);
    color: #718096;
    font-weight: 700;
    transition: cubic-bezier(0.075, 0.82, 0.165, 1);


}
</style>