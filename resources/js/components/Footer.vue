<template>
  <footer class="jb-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <p class="jb-footer-essay t-meri"> Hire the right people, get work done on time and work within your
            budget. Expert freelances are just a click away</p>
        </div>
        <div class="col-md-3 offset-md-2">
          <p class="jb-footer-header  t-bold ">LINKS</p>
          <ul class="footer-align">
            <li class="footer-item"><router-link to="/jobs" class="footer-link">Jobs</router-link></li>
            <li class="footer-item"><a class="footer-link" href="register.html">Register</a></li>
            <li class="footer-item"><a class="footer-link " href="login.html">Login</a></li>
            <li class="footer-item"><a class=footer-link href="work.html">Work</a></li>
            <li class="footer-item"><a class="footer-link" href="hire.html">Hire</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <p class="jb-footer-header  t-bold ">ASSIST</p>
          <ul class="footer-align">
            <li class="footer-item"><a class="footer-link" href="help">Help</a></li>
            <li class="footer-item"><a class="footer-link" href="faq">FAQ</a></li>
            <li class="footer-item"><a class="footer-link" href="Contact us">Contact us</a></li>
          </ul>
        </div>
      </div>

    </div>

    <div class="container mt-3">
      <div class="row">
        <div class="col-md-6">
          <ul class="footer-align">
            <li class="footer-item"><a class="footer-link " href="learn.html">Learn more about Jobs233</a>
            </li>
            <li class="footer-item"><a class="footer-link" href="read.html">Read our blog</a></li>
            <li class="footer-item"><a class="footer-link " href="login.html">Subscribe to our News
              Letter</a>
            </li>
            <li class="footer-item"><a class=footer-link href="conditions.html">Conditions of Use</a></li>
            <li class="footer-item"><a class="footer-link" href="privacy.html">Privacy Notice</a></li>
          </ul>
          <br>
          <p>© Copyright {{copyrightYear}} Poe Studios </p>

        </div>

        <div class="col-md-6">
          <p>+233(0)275762217</p>
          <p>help@jobs233.com</p>
          <p>info@jobs233.com</p>

          <div class="jb-social">
            <a class="social-link" href="#"> <i class="fab fa-linkedin-square"></i> </a>
            <a class="social-link" href="#"> <i class="fab fa-google-plus-square"></i></a>
            <a class="social-link" href="#"><i class="fab fa-instagram"></i></a>
            <a class="social-link" href="#"><i class="fab fa-facebook-square"></i> </a>
            <a class="social-link" href="#"><i class="fab fa-twitter-square"></i></a>
          </div>
        </div>


      </div>

    </div>


  </footer>
</template>

<script>
  export default {

      data(){
          return {

          }
      },
      computed:{
          copyrightYear(){

              let year = new Date().getFullYear();
              if(year !== 2020){

                  return 2020 +'-'+ year ;
              }
              return 2020;
          }
      }
  }
</script>

<style scoped lang="scss">

</style>
