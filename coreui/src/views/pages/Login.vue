<template>
  <section>
    <div :style="image" class="image" >
      <!-- <img v-bind:src="image" v-bind:alt="text"para una foto en concreto> -->
            <!-- <img v-bind:src="image" v-bind:alt="text"> para una foto solo-->

  <CContainer class="d-flex content-center min-vh-100">
    <!-- <h1 class="text-hide" style="background-image: url('C:\public\img\imagenes\ganaderia.jpg'); width: 50px; height: 50px;">Bootstrap</h1> -->
    
      <!-- <div v-bind:style ="{'background-image':'url(https://i.imgur.com/thWBPNU.jpg[/img])'}">
      </div> -->
      <!-- <section>
        <div :style="image" class="image">
          <img v-bind:src="image" v-bind:alt="text">
        </div>
      </section> aqui funciona-->

    
    
    

    <CRow>
      <CCol>
        <CCardGroup>
          <CCard class="p-4" style="width: 45rem; height: 22rem;" >
            <CCardBody>
              <CForm @submit.prevent="login" method="POST">
                <h1>Inicio de Sesión</h1>
                <p class="text-muted">Introduce tu correo y contraseña</p>
                <CInput
                  v-model="email"
                  prependHtml="<i class='cui-user'></i>"
                  placeholder="Email"
                  autocomplete="username email"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  v-model="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  placeholder="Contraseña"
                  type="password"
                  autocomplete="curent-password"
                >
                  <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                </CInput>
                <CRow>
                  <CCol col="4">
                    <CButton type="submit" color="primary" class="px-4">Iniciar</CButton>
                  </CCol>
                  <CCol col="6" class="text-right">
                    <CButton color="link" class="px-0">¿Has olvidado tu contraseña?</CButton>
                  </CCol>
                </CRow>
              </CForm>
            </CCardBody>
          </CCard>
          <!-- <CCard
            color="primary"
            text-color="white"
            class="text-center py-5 d-md-down-none"
            body-wrapper
          >            
            <br>
            <h2>Sign up</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <CButton
              color="primary"
              class="active mt-3"
              @click="goRegister()"
            >
              Register Now!
            </CButton>
          </CCard> -->
        </CCardGroup>
      </CCol>
    </CRow>
  </CContainer>
  </div>
  </section>
</template>

<script>

import axios from "axios";

    export default {
      name: 'Login',
      data() {
        return {
          email: '',
          password: '',
          showMessage: false,
          message: '',
          // backgroundImage: "https://i.imgur.com/thWBPNU.jpg[/img]",
          image: {backgroundImage: "url(https://i.imgur.com/LCPIENE.jpg[/img])"},
          // vaca solaimage: {backgroundImage: "url(https://i.imgur.com/Mp0yj1w.jpg[/img])"},

          // image: "https://i.imgur.com/thWBPNU.jpg[/img]",
          // [img]https://i.imgur.com/Mp0yj1w.jpg[/img]
          
        }
      
      },
      methods: {
        goRegister(){
          this.$router.push({ path: 'register' });
        },
        login() {
          let self = this;
          axios.post(  this.$apiAdress + '/api/login', {
          // axios.post(   'http://192.168.1.34:8000/api/login', {
            email: self.email,
            password: self.password,
          }).then(function (response) {
            self.email = '';
            self.password = '';
            localStorage.setItem("api_token", response.data.access_token);
            localStorage.setItem('roles', response.data.roles);
            self.$router.push({ path: 'dashboard' });
          })
          .catch(function (error) {
            // self.message = 'Incorrect E-mail or password';
            // console.log(self.message);
            // self.showMessage = true;
            console.log(error);
            alert("Usuario o Contraseña Incorrecta movil")
            // console.log(message);
          });
  
        }
      }
    }
    

</script>
<style>
    .image {
        /* height: 1000px; */
        width: 100%; 
        height: 100%;     
        background-size: cover;
        background-repeat: no-repeat;
        position: relative
    }
</style>