<template>
<footer class="footer">
    <div class="footer__tech">
        <div class="footer__logo">
            <img src="../assets/images/logo-large.png" alt="Monkey Blog" class="footer__img">
            <span class="footer__branch">Monkey Blog</span>
        </div>
        <div class="footer__install">
            <span class="footer__install--text">Tải ứng dụng trên</span>
            <img src="../assets/images/chplay.png" alt="chplay">
            <img src="../assets/images/store.png" alt="store" class="footer__install--store">
        </div>
    </div>
    <div class="footer__legacy">
        <div class="footer__contact">
            <span class="footer__contact--branch">Liên hệ</span>
            <span class="footer__contact--name">Công ty Cổ Phần DTORNUGC</span>
            <span class="footer__contact--name">Trực thuộc Công ty Cổ Phần DTORNUGC Việt Nam (DTORNUGC Vietnam JSC)</span>
            <span class="footer__contact--name">Người chịu trách nhiệm nội dung: Đặng Văn Trúc</span>
            <span class="footer__contact--name">Giấy phép MXH số 341/GP-TTTT do Bộ TTTT cấp ngày 31 tháng 08 năm 2023</span>
        </div>
        <div class="footer__contact">
            <span class="footer__contact--branch">Liên hệ hợp tác</span>
            <span class="footer__contact--name">Email: contact@dtornugc.com</span>
            <span class="footer__contact--name">Điện thoại: (+84) 977 062 149</span>
        </div>
        <div class="footer__contact">
            <span class="footer__contact--branch">© Copyright 2017 - 2023</span>
            <span class="footer__contact--name">Tầng 2, tòa nhà HL Tower, lô A2B, phố Hoàng Diệu, Thạch Thang, thành phố Đà Nẵng</span>
        </div>
    </div>

</footer>
</template>

<script>

</script>

<style lang="scss" scoped>
.footer {
    border-top: 1px solid var(--border-color);
    padding: 30px 130px;
    // background-color: #f1ebeb;
    margin-top: 80px;
    .footer__tech {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);

        .footer__install {
            display: flex;
            align-items: center;
            gap: 10px;
             color: var(--text-color-4);
            font-size: 14px;
            font-weight: 500;
            img {
                width: 100px;
                height: 35px;
            }
        }
    }

    .footer__logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 10px;

        img {
            width: 100px;
            height: 100px;
        }

        .footer__branch {
            color: var(--secondary-color);
            font-family: 'Quicksand', sans-serif;
            font-size: 32px;
        }
    }

    .footer__legacy {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        margin-top: 30px;
    }

    .footer__contact {
        display: flex;
        flex-direction: column;
        gap: 5px;

        .footer__contact--branch {
            color: var(--text-color-4);
            font-size: 16px;
            font-weight: 700;
        }

        .footer__contact--name {
            color: var(--text-color-4);
            font-size: 13px;
            font-weight: 400;
        }
    }
}

@media screen and (max-width: 768px) {
    .footer {

        .footer__legacy {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            margin-top: 30px;
        }
    }
}

@media screen and (max-width: 640px) {
    .footer {

        .footer__legacy {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            margin-top: 30px;
        }
    }
}
</style>
