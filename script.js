  let app = new Vue({
    el: '#app',
    data: {
      message: 'Hello Vue!',
      isTocId: true,
      isFlex: true,
    },
    methods:{
      toggleBtn(){
        this.isTocId = !this.isTocId;
      },
      toggleBtnFlex(){
        this.isFlex = !this.isFlex;
      },
    }
  })
