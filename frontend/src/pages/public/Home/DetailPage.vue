<template>
    <div class="detail__container">
        <div class="detail__heading">
            <img
                src="https://images.unsplash.com/photo-1692107329566-0ce6353eedf5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" />
            <div class="detail__infor">
                <div class="detail__category">
                    <span>Đời sống</span>
                </div>
                <p class="detail__title">
                    Lời thú nhận của anh Chàng IT sinh năm 2001
                </p>
                <div class="detail__view">
                    <div class="detail__view--public">
                        <div class="detail__user">
                            <img src="../../../assets/images/banner.png" />
                            <div class="detail__user__infor">
                                <span class="detail__user__name">Bin Zét</span>
                            </div>
                        </div>
                        <span class="detail__time">28/10</span>
                    </div>
                    <div class="detail_view--interact">
                        <span class="detail__viewer" @click="handleOpenComment">
                            <ion-icon name="chatbubbles-outline"></ion-icon>220
                        </span>
                        <span class="detail__viewer">
                            <ion-icon name="eye-outline"></ion-icon> 1208
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div class="detail__content">
            <div class="detail__wrapper">
                <p class="detail__text">
                    Khó khăn lớn nhất trong đời tôi cho tới giờ vẫn luôn là học cách phớt lờ những cám dỗ. Đúng vậy, phớt lờ
                    thay vì vượt qua. Tôi vẫn đủ tỉnh táo để không sa đà vào bất cứ tệ nạn nào quá nghiêm trọng, nhưng chỉ
                    riêng game thôi đã khiến tôi khổ sở đôi ba lần, và cũng ngốn không ít nước mắt của người nhà tôi (kỳ lạ
                    là không phải của tôi vì tôi chưa bao giờ ăn đập vì bị bắt đi net).
                    Như bất cứ thằng con trai nào với gia cảnh bình thường, sống ở miền quê, cộng thêm việc hiếm khi được
                    tiếp xúc với các trò chơi điện tử từ bé, sự ra đời của các quán net bỗng thu hút tôi một cách lạ lùng.
                    Các quán net sớm trở thành mái nhà thứ hai của tôi, chỉ còn nước là chưa cắm trại ăn ngủ ở đó thôi.
                    "Nắng tháng Sáu chết cả cá cờ" nhưng tinh thần game thủ thì còn khuya mới chết. Tôi vẫn nhớ những ngày
                    đạp xe lóc cóc 4, 5 cây số giữa trưa hè 40 độ ra quán net rồi an tọa ở đó cả buổi chiều, trong căn gác
                    mái nóng nực kinh hồn, ngột ngạt, không khí nồng nặc nicotine và học được cách nghe tiếng chửi thề như
                    nghe cô giáo giảng bài trong giờ Văn.
                    Ngẫm lại những ngày đó không làm tôi hối hận mà thấy ngớ ngẩn, dù không ít lần tôi trốn học, nói dối ông
                    bà để đi chơi game, nhưng tôi tự hào vì ít ra nó còn vui, và vì tôi có bạn, những người tới giờ vẫn là
                    bạn thân của tôi.
                    Một điều khác khiến tôi tự hào là vì suốt 10 năm ‘nghiện ngập’, tôi chỉ chơi độc một game Liên Minh
                    Huyền Thoại. Như tất cả anh em vẫn bông đùa rằng, nếu có thể thu hồi tất cả số tiền đã đổ vào game trong
                    suốt những năm qua, khối đứa sẽ giàu sụ và nếu anh em nào từng nói câu đó đang ở đây thì - tôi đồng ý
                    với anh em nhé.
                </p>
            </div>
        </div>
        <CardAuthor />

        <h1 class="detail__related__title">Bài viết liên quan</h1>
        <div class="detail__related">
            <span class="detail__controller">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </span>
            <swiper :slides-per-view="4" :space-between="20" ref="swiper" class="detail__swiper">
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
            </swiper>
            <span class="detail__controller">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </span>
        </div>

        <!-- Special -->
        <h1 class="detail__related__title">Bài viết nổi bật</h1>

        <div class="detail__related">
            <span class="detail__controller">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </span>
            <swiper :slides-per-view="4" :space-between="20" ref="swiper" class="detail__swiper">
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
                <swiper-slide>
                    <CardNew />
                </swiper-slide>
            </swiper>
            <span class="detail__controller">
                <ion-icon name="arrow-forward-outline"></ion-icon>
            </span>
        </div>
    </div>
    <Comment :isOpenComment="isOpenComment" :handleOpenComment="handleOpenComment" />
</template>

<script setup>
import {
    ref,
    watchEffect
} from "vue";
import CardNew from "../../../components/CardNew.vue";
import CardAuthor from "../../../components/CardAuthor.vue"
import Comment from "../../public/Home/Comment/Comment.vue"
import {
    Swiper,
    SwiperSlide
} from "swiper/vue";
import "swiper/swiper-bundle.css";
import "swiper/css";

let isOpenComment = ref(false);

const handleOpenComment = () => {
    isOpenComment.value = !isOpenComment.value
}

watchEffect(() => {
    window.scrollTo(0, 0);

})
</script>

<style lang="scss" scoped>
.detail__container {
    padding: 120px 130px;
}

.detail__heading {
    display: flex;
    align-items: center;
    position: relative;

    img {
        max-width: 600px;
        width: 100%;
        height: 465px;
        border-radius: 12px;
        margin-right: 70px;
    }
}

.detail__category {
    width: 150px;
    max-width: 100%;
    padding: 10px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    display: flex;
    justify-content: center;
}

.detail__title {
    font-size: 32px;
    color: var(--btn-color);
    font-weight: 700;
    margin-top: 20px;
    line-height: 1.3;
    margin-bottom: 20px;
}

.detail__view {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: var(--text-color-4);
    font-weight: 700;
}

.detail__view--public {
    display: flex;
    align-items: center;
}

.detail__user {
    display: flex;
    align-items: center;
    margin-right: 20px;

    img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 1px solid var(--border-color);
        border-radius: 50%;
        margin-right: 10px;
    }
}

.detail_view--interact {
    display: flex;
    gap: 20px;
    font-size: 14px;

    .detail__viewer {
        cursor: pointer;
        display: flex;
        align-items: center;
    }
}

.detail__content {
    padding: 20px 250px;
    background-color: var(--white-color);
    margin: 70px 0px;
}

.detail__wrapper {
    margin: 0 auto;
    background-color: var(--white-color);

    .detail__text {
        font-family: "Noto Serif", Regular, Times New Roman;
        white-space: pre-wrap;
        word-break: break-word;
        line-height: 1.4;
    }
}



.detail__related {
    display: flex;
    margin-top: 30px;
    gap: 10px;
    align-items: center;
}

.detail__controller {
    cursor: pointer;
    padding: 7px;
    border-radius: 50%;
    border: 1px solid var(--border-color);
}

.detail__swiper {
    padding: 5px;
}

.detail__related__title {
    margin: 80px 0px 30px 0px;
    padding-top: 10px;
    font-size: 28px;
    color: var(--btn-color);
    font-weight: 600;
    position: relative;

    &::after {
        position: absolute;
        content: "";
        top: 0;
        background-color: var(--primary-color);
        left: 0;
        width: 35px;
        height: 3px;
    }
}
</style>
