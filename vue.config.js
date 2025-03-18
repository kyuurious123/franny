module.exports = {
  // 상대 경로로 빌드
  publicPath: './',
  
  // ESM 모듈 사용을 피하기 위한 설정
  chainWebpack: config => {
    config.output.set('module', false);
  }
}