<template >
    <header class="header__container">
        <div class="header__top">
            <div class="header__left">
                <img src="../assets/images/logo-small.png" class="header__logo"/>
                <ul class="header__menu">
                    <li class="header__item">
                        Home
                    </li>
                    <li class="header__item">
                        Blog
                    </li>
                    <li class="header__item">
                        Contact
                    </li>
                </ul>
            </div>

            <!-- <div class="header__right"> -->
                <div class="header__search">
                    <input type="text" class="search__input" placeholder="Search post..."/>
                    <span class="search__icon"><ion-icon name="search-outline"></ion-icon></span>
                </div>
                <button class="header__btn--signup">Đăng ký</button>
                <button class="header__btn">Đăng nhập</button>
            </div>
        <!-- </div> -->
        
    </header>
</template>
<script>
export default {
    
}
</script>
<style lang="scss">
.header__container {
    padding: 35px 122px;
}
.header__top {
    display: flex;
    align-items: center;
}
.header__left {
    display: flex;
    align-items: center;
}
.header__menu {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-left: 40px;
}
.header__item {
    font-size: 18px;
    font-weight: 700;
}
.header__logo{
    display: block;
    max-width: 50px;
}
// .header__right{
//     margin-left: auto;
//     flex:1;
// }
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
</style>