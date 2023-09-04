<!-- <template>
    <div class='loading-block'>
        <div class='lds-roller'>
            <img src="../assets/images/loading.gif" />
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
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    background-color: rgba(0, 0, 0, 0.5);

    img {
        margin: 0 auto;
    }

    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
}
</style> -->

<template >
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
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    background-color: rgba(0, 0, 0, 0.5);
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
</style>

