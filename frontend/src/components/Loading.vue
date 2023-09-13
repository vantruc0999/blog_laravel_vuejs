<template>
    <div class='loading-block'>
        <div class="loading__top">
            <div class="lds-default">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="loading__logo">
                <span class="loading__text">M</span>
                <span class="loading__text loading__text--sub">O</span>
                <span class="loading__text">N</span>
                <span class="loading__text">K</span>
                <span class="loading__text loading__text--sub1">E</span>
                <span class="loading__text">Y </span>
                <span class="loading__text loading__text--sub1">B</span>
                <span class="loading__text">L</span>
                <span class="loading__text loading__text--sub">O</span>
                <span class="loading__text">G</span>
            </div>
        </div>
        <div class="loading__intro">
            <span class="loading__from">From</span>
            <div class="loading__author">
                <img src="../assets/images/gautruc.png" alt="">
                <h3 class="loaiding__name">Đông - Trúc</h3>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.loading-block {
    width: 100vw;
    height: 100vh;
    position: fixed;
    display: flex;
    flex-direction: column;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    align-items: center;
    justify-content: space-around;
    z-index: 1000;
    // background-color: rgba(0, 0, 0, 0.5);
    background-color: var(--white-color);

    .loading__intro {
        margin-top: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        .loading__from {
            color: var(--text-color-4);
            font-size: 16px;
            font-weight: 500;
        }

        .loading__author {
            display: flex;
            align-items: center;
            font-family: 'Pacifico', cursive;
            font-size: 20px;

            img {
                width: 180px;
                height: 120px;
                object-fit: cover;
            }
        }
    }

    .loading__top {
        display: flex;
        align-items: center;
        margin-bottom: 150px;
        gap: 20px;

        .loading__logo {
            font-family: 'Pacifico', cursive;
            font-size: 48px;
            font-weight: 500;

            .loading__text {

                &--sub {
                    color: var(--green-color);
                }

                &--sub1 {
                    color: var(--primary-color);
                }
            }
        }
    }

    .lds-default {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-default div {
        position: absolute;
        width: 6px;
        height: 6px;
        background: rgb(115, 193, 76);
        border-radius: 50%;
        animation: lds-default 1.2s linear infinite;
    }

    .lds-default div:nth-child(1) {
        animation-delay: 0s;
        top: 37px;
        left: 66px;
    }

    .lds-default div:nth-child(2) {
        animation-delay: -0.1s;
        top: 22px;
        left: 62px;
    }

    .lds-default div:nth-child(3) {
        animation-delay: -0.2s;
        top: 11px;
        left: 52px;
    }

    .lds-default div:nth-child(4) {
        animation-delay: -0.3s;
        top: 7px;
        left: 37px;
    }

    .lds-default div:nth-child(5) {
        animation-delay: -0.4s;
        top: 11px;
        left: 22px;
    }

    .lds-default div:nth-child(6) {
        animation-delay: -0.5s;
        top: 22px;
        left: 11px;
    }

    .lds-default div:nth-child(7) {
        animation-delay: -0.6s;
        top: 37px;
        left: 7px;
    }

    .lds-default div:nth-child(8) {
        animation-delay: -0.7s;
        top: 52px;
        left: 11px;
    }

    .lds-default div:nth-child(9) {
        animation-delay: -0.8s;
        top: 62px;
        left: 22px;
    }

    .lds-default div:nth-child(10) {
        animation-delay: -0.9s;
        top: 66px;
        left: 37px;
    }

    .lds-default div:nth-child(11) {
        animation-delay: -1s;
        top: 62px;
        left: 52px;
    }

    .lds-default div:nth-child(12) {
        animation-delay: -1.1s;
        top: 52px;
        left: 62px;
    }

    @keyframes lds-default {

        0%,
        20%,
        80%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.5);
        }
    }

}
</style>

<!-- <template >
    <div class="loading-block">
        <svg class="ip" viewBox="0 0 256 128" width="256px" height="128px" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="grad1" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0%" stop-color="#5ebd3e" />
                    <stop offset="33%" stop-color="#ffb900" />
                    <stop offset="67%" stop-color="#f78200" />
                    <stop offset="100%" stop-color="#e23838" />
                </linearGradient>
                <linearGradient id="grad2" x1="1" y1="0" x2="0" y2="0">
                    <stop offset="0%" stop-color="#e23838" />
                    <stop offset="33%" stop-color="#973999" />
                    <stop offset="67%" stop-color="#009cdf" />
                    <stop offset="100%" stop-color="#5ebd3e" />
                </linearGradient>
            </defs>
            <g fill="none" stroke-linecap="round" stroke-width="16">
                <g class="ip__track" stroke="#ddd">
                    <path d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56" />
                    <path d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64" />
                </g>
                <g stroke-dasharray="180 656">
                    <path class="ip__worm1" stroke="url(#grad1)" stroke-dashoffset="0"
                        d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56" />
                    <path class="ip__worm2" stroke="url(#grad2)" stroke-dashoffset="358"
                        d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64" />
                </g>
            </g>
        </svg>
        <div class="loading__intro">
            <span class="loading__from">From</span>
            <div class="loading__author">
                <img src="../assets/images/gautruc.png" alt="">
                <h3 class="loaiding__name">Đông - Trúc</h3>
            </div>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
<style lang="scss" scoped>
* {
    border: 0;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

:root {
    --hue: 223;
    --bg: hsl(var(--hue), 90%, 95%);
    --fg: hsl(var(--hue), 90%, 5%);
    --trans-dur: 0.3s;
    font-size: calc(16px + (24 - 16) * (100vw - 320px) / (1280 - 320));
}

body {
    background-color: var(--bg);
    color: var(--fg);
    font: 1em/1.5 sans-serif;
    height: 100vh;
    display: grid;
    place-items: center;
    transition: background-color var(--trans-dur);
}

main {
    padding: 1.5em 0;
}

.loading-block {
    width: 100vw;
    height: 100vh;
    position: fixed;
    display: flex;
    flex-direction: column;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    // background-color: rgba(0, 0, 0, 0.5);
    background-color: var(--white-color);

    .loading__intro {
        margin-top: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        .loading__from {
            color: var(--text-color-4);
            font-size: 18px;
            font-weight: 500;
        }

        .loading__author {
            display: flex;
            align-items: center;
            font-family: 'Pacifico', cursive;
            font-size: 22px;

            img {
                width: 200px;
                height: 170px;
                object-fit: cover;
            }
        }
    }
}

.ip {
    width: 11em;
    height: 4em;
}

.ip__track {
    stroke: hsl(var(--hue), 90%, 90%);
    transition: stroke var(--trans-dur);
}

.ip__worm1,
.ip__worm2 {
    animation: worm1 1.5s linear infinite;
}

.ip__worm2 {
    animation-name: worm2;
}

@media (prefers-color-scheme: dark) {
    :root {
        --bg: hsl(var(--hue), 90%, 5%);
        --fg: hsl(var(--hue), 90%, 95%);
    }

    .ip__track {
        stroke: hsl(var(--hue), 90%, 15%);
    }
}

@keyframes worm1 {
    from {
        stroke-dashoffset: 0;
    }

    50% {
        animation-timing-function: steps(1);
        stroke-dashoffset: -358;
    }

    50.01% {
        animation-timing-function: linear;
        stroke-dashoffset: 358;
    }

    to {
        stroke-dashoffset: 0;
    }
}

@keyframes worm2 {
    from {
        stroke-dashoffset: 358;
    }

    50% {
        stroke-dashoffset: 0;
    }

    to {
        stroke-dashoffset: -358;
    }
}
</style> -->

