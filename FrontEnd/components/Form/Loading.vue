<template>
  <div
    class="fixed max-h-screen inset-0 bg-black z-20 bg-opacity-50 flex justify-center items-center text-green-700"
  >
    <svg
      version="1.1"
      viewBox="0 0 64 64"
      width="1em"
      xmlns="http://www.w3.org/2000/svg"
      id="spinner"
    >
      <circle
        class="path-gradient"
        cx="32"
        cy="32"
        r="28"
        fill="none"
        stroke="url(#sGD)"
        stroke-width="8"
      />
      <path
        class="path-solid"
        d="M 32,4 A 28 28,0,0,0,32,60"
        fill="none"
        stroke="#000"
        stroke-width="8"
        stroke-linecap="round"
      />

      <defs>
        <linearGradient
          id="sGD"
          gradientUnits="userSpaceOnUse"
          x1="32"
          y1="0"
          x2="32"
          y2="64"
        >
          <stop stop-color="#000" offset="0.1" stop-opacity="0" class="stop1"></stop>
          <stop stop-color="#000" offset=".9" stop-opacity="1" class="stop2"></stop>
        </linearGradient>
      </defs>

      <animateTransform
        values="0,0,0;360,0,0"
        attributeName="transform"
        type="rotate"
        repeatCount="indefinite"
        dur="750ms"
      ></animateTransform>
    </svg>
  </div>
</template>

<style scope>
#spinner {
  width: 30px;
}

#spinner #sGD stop {
  stop-color: #16a34a;
}

#spinner .path-solid {
  stroke: #16a34a;
}
</style>
