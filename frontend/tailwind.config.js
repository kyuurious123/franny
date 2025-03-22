module.exports = {
  content: [
    './index.html',
    './src/**/*.{js,ts,jsx,tsx,vue}',
    './src/*.{js,ts,jsx,tsx,vue}', // src 폴더 직접 하위의 파일들을 명시적으로 포함
  ],
  theme: {
    extend: {},
  },
  plugins: [
  ],
}