<template>
    <header class="header__container">
        <div class="header__top">
            <div class="header__left">
                <router-link to="/">
                    <img src="../assets/images/logo-monkey.png" class="header__logo" />
                </router-link>
                <ul class="header__menu">
                    <a href="https://www.facebook.com/profile.php?id=100092331052158">
                        <ion-icon name="logo-facebook"></ion-icon>
                    </a>

                    <a href="https://www.youtube.com/@BabyMonkeyAnimal" target="_blank">
                        <ion-icon name="logo-youtube"></ion-icon>
                    </a>
                    <a href="https://www.lazada.vn/products/monkey-fun-2022-mu-doi-dau-ca-mau-xanh-la-cay-mat-na-trang-phuc-cosplay-vui-nhon-unisex-mat-na-doi-dau-mat-na-quy-dece-flor-mat-na-dau-ca-xanh-silicon-cho-nguoi-lon-unisex-bia-mu-dao-cu-trang-phuc-hoa-trang-du-tiec-i1949917117-s8966157445.html?c=&channelLpJumpArgs=&clickTrackInfo=query%253Amonkey%252Bshop%253Bnid%253A1949917117%253Bsrc%253ALazadaMainSrp%253Brn%253Ab60880b8e4a395e437ff69efb586adbd%253Bregion%253Avn%253Bsku%253A1949917117_VNAMZ%253Bprice%253A76000%253Bclient%253Adesktop%253Bsupplier_id%253A200191533994%253Bpromotion_biz%253A%253Basc_category_id%253A10242%253Bitem_id%253A1949917117%253Bsku_id%253A8966157445%253Bshop_id%253A2843787&fastshipping=0&freeshipping=0&fs_ab=2&fuse_fs=&lang=vi&location=H%C3%A0%20N%E1%BB%99i&price=7.6E%204&priceCompare=skuId%3A8966157445%3Bsource%3Alazada-search-voucher%3Bsn%3Ab60880b8e4a395e437ff69efb586adbd%3BoriginPrice%3A76000%3BdisplayPrice%3A76000%3BsinglePromotionId%3A-1%3BsingleToolCode%3AmockedSalePrice%3BvoucherPricePlugin%3A0%3Btimestamp%3A1692776197730&ratingscore=4.631578947368421&request_id=b60880b8e4a395e437ff69efb586adbd&review=57&sale=437&search=1&source=search&spm=a2o4n.searchlist.list.i40.69fc6c06yMAWWO&stock=1"
                        target="_blank">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a>
                </ul>
            </div>
            <!-- <div class="header__right"> -->
            <div class="header__right" v-if="!isAuth">
                <div class="header__search">
                    <input type="text" class="search__input" v-model="searchText"
                        placeholder="Tìm kiếm theo tiêu đề tác giả hoặc tags" />
                    <span class="search__icon" @click="handleSearch">
                        <ion-icon name="search-outline"></ion-icon>
                    </span>
                </div>
                <router-link to="/auth/signup" class="header__btn--signup">
                    Đăng ký
                </router-link>
                <router-link to="/auth/signin" class="header__btn">
                    Đăng nhập
                </router-link>
            </div>
            <div class="header__user" v-else>
                <div class="header__search" v-if="$route.path !== '/blog-post'">
                    <input type="text" class="search__input" v-model="searchText"
                        placeholder="Tìm kiếm theo tiêu đề tác giả hoặc tags" />
                    <span class="search__icon" @click="handleSearch">
                        <ion-icon name="search-outline"></ion-icon>
                    </span>
                </div>
                <span class="header__notifi"><ion-icon name="notifications-outline"></ion-icon></span>
                <router-link to="/blog-post" v-if="$route.path !== '/blog-post'">
                    <button class="header__write__btn">
                        <img src="../assets/images/pen.png" class="header__write__pen">
                        Viết bài
                    </button>
                </router-link>
                <div class="header__avatar" @click="handleOpenOptions">
                    <img :src="'http://127.0.0.1:8000/images/avatar/' + authStore.user.blogger_info?.profile_image"
                        alt="avatar" v-if="authStore.user.blogger_info?.profile_image">
                    <img src="../assets/images/avatar-default.png" alt="" v-else>
                </div>
                <OptionUser :isOpen="isOpen" />
            </div>
        </div>
        <!-- </div> -->
        <div class="header__options">
            <router-link :to="`/posts/category/${tag?.id}`" class="header__option"
                v-for="(tag, index) in postStore.tags.slice(0, 6)" :key="index" @click="handleFilterByCategori(tag?.id)">
                {{ tag.name }}
            </router-link>
            <ion-icon name="menu-outline" class="header__icon" @click="handleChangeOptionMenu"></ion-icon>
            <div class="option__tag" :class="{ activeOption: isOptionMenu }">
                <ul class="option__menu" v-for="(tag, index) in postStore.tags.slice(5)" :key="index"
                    @click="handleFilterByCategori(tag?.id)">
                    <li class=" option__item">
                        {{ tag.name }}
                    </li>
                </ul>
            </div>
        </div>

    </header>
</template>

<script setup>
import {
    ref, onMounted
} from 'vue';
import OptionUser from "../components/OptionUser.vue"
import { useAuthStore } from '../stores/authStore';
import { usePostStore } from '../stores/postStore';
import { useRouter } from 'vue-router';

const authStore = useAuthStore()
const postStore = usePostStore()
onMounted(async () => {
    await authStore.getMyProfile()
    await postStore.getAllTags();
})
const isOptionMenu = ref(false)
const handleChangeOptionMenu = () => {
    isOptionMenu.value = !isOptionMenu.value
}
// const handleCloseOptionMenu = () => {
//     isOptionMenu.value = false
// }
const route = useRouter()
let searchText = ref("")
const isAuth = ref(localStorage.getItem("isLogin"));
const userData = ref(JSON.parse(localStorage.getItem("user")));

let isOpen = ref(false);

const handleOpenOptions = () => {
    isOpen.value = !isOpen.value;
};

const handleSearch = async () => {
    const searchValue = searchText.value.trim();
    if (searchValue) {
        await postStore.searchPost(searchValue, "");
        route.push({ path: '/filter/filter-post', query: { search: searchValue } });
    } else {
        route.push({ path: '/filter/filter-post' });
    }
};

const handleFilterByCategori = async (id) => {
    if (id) {
        await postStore.filterByCategori(id);
        this.$router.push(`/posts/category/${id}`);
    } else {
        this.$router.push('/posts/category/');
    }
}

</script>

<style lang="scss" scoped>
.header__container {
    height: 120px;
    padding: 0px 122px;
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    background-color: var(--white-color);
    box-shadow: 0 -2px 20px rgb(0 0 0 / 10%);
    z-index: 900;
    box-shadow: 0 -2px 20px rgb(0 0 0 / 10%);
    border-bottom: 1px solid #e8ebed;

    .header__options {
        display: flex;
        cursor: pointer;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
        color: var(--text-color-4);
        margin-top: 10px;
        position: relative;

        .header__icon {
            font-size: 20px;
        }

        .option__tag {
            position: absolute;
            right: 0;
            top: 36px;
            width: 250px;
            background-color: var(--white-color);
            height: 0;
            overflow-y: auto;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            border-radius: 2px;

            .option__menu {
                display: flex;
                flex-direction: column;
                color: var(--black-color);
                font-weight: 500;
                width: 100%;

                .option__item {
                    padding: 15px;
                    width: 100%;

                    &:hover {
                        background-color: var(--border-color);
                    }
                }
            }
        }

        .activeOption {
            min-height: 500px;
        }
    }
}

.header__top {
    margin-top: 5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header__left {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header__menu {
    display: flex;
    align-items: center;
    gap: 20px;
    font-size: 22px;
    margin-top: 20px;
    margin-left: 20px;
}

.header__item {
    cursor: pointer;
    font-size: 18px;
    font-weight: 700;
}

.header__logo {
    display: block;
    max-width: 150px;
    border-right: 1px solid var(--primary-color);
    padding-right: 20px;
    height: 40px;
}

.header__right {
    display: flex;
    flex: 1;
}

.header__search {
    margin-left: auto;
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: 15px;
    width: 100%;
    max-width: 400px;
    position: relative;
    background-color: #f6f8fc;
}

.search__input {
    width: 100%;
    padding-right: 35px;
    background-color: #f6f8fc;

    &::placeholder {
        font-size: 12px;
    }

}

.search__icon {
    position: absolute;
    top: 54%;
    transform: translateY(-50%);
    right: 25px;
    cursor: pointer;
}

.header__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 130px;
    height: 45px;
    color: var(--white-color);
    font-weight: 500;
    font-size: 16px;
    cursor: pointer;
    background-color: var(--btn-color);
    border-radius: 30px;
    margin-left: 10px;
}

.header__btn--signup {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 130px;
    height: 45px;
    color: var(--black-color);
    font-weight: 500;
    font-size: 16px;
    cursor: pointer;
    background-color: var(--white-color);
    border-radius: 30px;
    margin-left: 10px;
    border: 1px solid var(--border-color);
}

// after login
.header__avatar {
    width: 40px;
    height: 40px;
    border-radius: 1px solid var(--border-color);

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
    justify-content: flex-end;

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

@media only screen and (max-width: 1020px) {
    .header__container {
        height: 80px;

        .header__options {
            display: none;
        }
    }

}
</style>
