<template >
    <div class="signature__wrapper">
        <div class="signature__user">
            <router-link to="/profile">
                <div class="signature__user__left">
                    <img class="signature__user__img"
                        src="https://images.unsplash.com/photo-1682685797366-715d29e33f9d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80"
                        alt="">
                    <div class="signature__user__infor">
                        <span class="signature__user__author">Hải Haven</span>
                        <span class="signature__user__nickname">Ein Verrückter</span>
                    </div>
                </div>
            </router-link>
            <div class="signature__user__right">
                <button class="signature__user__btn">Theo dõi</button>
            </div>
        </div>
        <div class="signature__user">
            <router-link to="/profile">
                <div class="signature__user__left">
                    <img class="signature__user__img" src="../../../../assets/images/bin2.jpg" alt="">
                    <div class="signature__user__infor">
                        <span class="signature__user__author">Jackies Bin Duong</span>
                        <span class="signature__user__nickname">Daiza Vú</span>
                    </div>
                </div>
            </router-link>
            <div class="signature__user__right">
                <button class="signature__user__btn">Theo dõi</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
<style lang="scss" scoped>
.signature__wrapper {
    width: 100%;

    .signature__user {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;

        .signature__user__left {
            display: flex;
            gap: 10px;

            .signature__user__infor {
                display: flex;
                flex-direction: column;
                font-size: 15px;
                gap: 5px;

                .signature__user__author {
                    font-weight: 700;
                }

                .signature__user__nickname {
                    font-size: 14px;
                    font-weight: 400;
                    color: #6a6666;
                }
            }
        }

        .signature__user__img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            margin-right: 0;
            border-radius: 50%;
        }

        .signature__user__btn {
            padding: 12px;
            border-radius: 12px;
            width: 120px;
        }
    }
}
</style>