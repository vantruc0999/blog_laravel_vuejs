<template>

<header class="header__container">
    <div class="header__top">
        <div class="header__left">
            <router-link to="/">
                <img src="../assets/images/logo-small.png" class="header__logo" />
            </router-link>
            <ul class="header__menu">
                <a href="https://www.facebook.com/profile.php?id=100092331052158">
                    <ion-icon name="logo-facebook"></ion-icon>
                </a>
                
                <a href="https://www.youtube.com/@BabyMonkeyAnimal" target="_blank">
                    <ion-icon name="logo-youtube"></ion-icon>
                </a>
                <a href="https://www.lazada.vn/products/monkey-fun-2022-mu-doi-dau-ca-mau-xanh-la-cay-mat-na-trang-phuc-cosplay-vui-nhon-unisex-mat-na-doi-dau-mat-na-quy-dece-flor-mat-na-dau-ca-xanh-silicon-cho-nguoi-lon-unisex-bia-mu-dao-cu-trang-phuc-hoa-trang-du-tiec-i1949917117-s8966157445.html?c=&channelLpJumpArgs=&clickTrackInfo=query%253Amonkey%252Bshop%253Bnid%253A1949917117%253Bsrc%253ALazadaMainSrp%253Brn%253Ab60880b8e4a395e437ff69efb586adbd%253Bregion%253Avn%253Bsku%253A1949917117_VNAMZ%253Bprice%253A76000%253Bclient%253Adesktop%253Bsupplier_id%253A200191533994%253Bpromotion_biz%253A%253Basc_category_id%253A10242%253Bitem_id%253A1949917117%253Bsku_id%253A8966157445%253Bshop_id%253A2843787&fastshipping=0&freeshipping=0&fs_ab=2&fuse_fs=&lang=vi&location=H%C3%A0%20N%E1%BB%99i&price=7.6E%204&priceCompare=skuId%3A8966157445%3Bsource%3Alazada-search-voucher%3Bsn%3Ab60880b8e4a395e437ff69efb586adbd%3BoriginPrice%3A76000%3BdisplayPrice%3A76000%3BsinglePromotionId%3A-1%3BsingleToolCode%3AmockedSalePrice%3BvoucherPricePlugin%3A0%3Btimestamp%3A1692776197730&ratingscore=4.631578947368421&request_id=b60880b8e4a395e437ff69efb586adbd&review=57&sale=437&search=1&source=search&spm=a2o4n.searchlist.list.i40.69fc6c06yMAWWO&stock=1" target="_blank">
                    <ion-icon name="logo-instagram"></ion-icon>
                </a>
            </ul>
        </div>
        <!-- <div class="header__right"> -->
        <div class="header__right" v-if="isAuth">
            <div class="header__search">
                <input type="text" class="search__input" placeholder="Search post..." />
                <span class="search__icon">
                    <ion-icon name="search-outline"></ion-icon>
                </span>
            </div>
            <router-link to="/auth/signup" class="header__btn--signup">
                <!-- <button >Đăng nhập</button> -->
                Đăng ký
            </router-link>
            <router-link to="/auth/signin" class="header__btn">
                <!-- <button >Đăng nhập</button> -->
                Đăng nhập
            </router-link>
        </div>
        <div class="header__user" v-else>
            <div class="header__search">
        
                    <input type="text" class="search__input" placeholder="Search post..." />
                    <span class="search__icon">
                        <ion-icon name="search-outline"></ion-icon>
                    </span>
            </div>
            <span class="header__notifi"><ion-icon name="notifications-outline"></ion-icon></span>
            <button class="header__write__btn"><img src="../assets/images/pen.png" class="header__write__pen">Viết bài</button>
            <div class="header__avatar" @click="handleOpenOptions">
                <img src="https://images.unsplash.com/photo-1692736230086-970c58a6af31?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=388&q=80" alt="">
            </div>
            <OptionUser :isOpen="isOpen"/>
        </div>
    </div>
    <!-- </div> -->
    <div class="header__category">
        <ul class="header__menu">
            
        </ul>
    </div>
</header>
</template>

<script setup>
import {
    ref
} from 'vue';
import OptionUser from "../components/OptionUser.vue"
const isAuth = ref(false)
let isOpen = ref(false);

const handleOpenOptions = () => {
    isOpen.value = !isOpen.value;
};

</script>

<style lang="scss" scoped>
.header__container {
    max-width: 1528px;
    padding: 15px 122px;
    position: fixed;
    width: 100vw;
    top: 0;
    right: 0;
    left: 0;
    margin: 0 auto;
    border-bottom: 1px solid #e8ebed;
    box-shadow: 0 -2px 20px rgb(0 0 0 / 10%);
    z-index: 900;
    background-color: var(--white-color);
}

.header__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header__left {
    display: flex;
    align-items: center;
}

.header__menu {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-left: 10px;
    font-size: 22px;
}

.header__item {
    cursor: pointer;
    font-size: 18px;
    font-weight: 700;
}

.header__logo {
    display: block;
    max-width: 70px;
    border-right: 1px solid var(--primary-color);
    padding-right: 20px;

}

.header__right {
    display: flex;
    flex: 1;
}

.header__search {
    margin-left: auto;
    padding: 13px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    width: 100%;
    max-width: 320px;
    position: relative;
}

.search__input {
    width: 100%;
    padding-right: 35px;
}

.search__icon {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 25px;
    cursor: pointer;
}

.header__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 160px;
    height: 45px;
    color: var(--white-color);
    font-weight: 700;
    font-size: 18px;
    cursor: pointer;
    background-color: var(--btn-color);
    border-radius: 10px;
    margin-left: 10px;
}

.header__btn--signup {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 160px;
    height: 45px;
    color: var(--black-color);
    font-weight: 700;
    font-size: 18px;
    cursor: pointer;
    background-color: var(--white-color);
    border-radius: 10px;
    margin-left: 10px;
    border: 1px solid var(--border-color);
}

// after login
.header__avatar {
    width: 40px;
    height: 40px;

    img {
        cursor: pointer;
        width: 100%;
        border-radius: 50%;
        object-fit: cover;
        height: 100%;
    }
}

.header__user {
    display: flex;
    gap: 10px;
    width: 100%;
    .header__write__btn {
        border-radius: 16px;
        background-color: var(--white-color);
        border: 1px solid var(--border-color);
        width: 120px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        .header__write__pen {
    
            width: 20px;
            height: 20px;
        }
    }
    .header__notifi {
        display: inline-block;
        font-size: 23px;
        margin-top: 10px;
        cursor: pointer;
    }

}

.router-link-exact-active {
    color: var(----primary-color);
}
</style>
