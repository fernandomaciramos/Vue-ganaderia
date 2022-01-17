<template>
  <div class="d-flex align-items-center min-vh-10">
    <CContainer fluid>
      <CRow class="justify-content-left">
        <CCol md="6">
          <CCard class="mx-2 mb-0">
            <CCardBody class="p-4">
              <CForm @submit.prevent="register" method="POST">
                <h1>Añadir Usuario</h1>
                <p class="text-muted">Rellena los campos para añadir el usuario</p>
                <CInput
                  placeholder="Nombre"
                  prependHtml="<i class='cui-user'></i>"
                  autocomplete="username"
                  v-model="name"
                  valid-feedback="Thank you :)"
                  invalid-feedback="Campo vacío no válido"
                  :is-valid="validatorvacio"
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  placeholder="Email"
                  prepend="@"
                  autocomplete="email"
                  v-model="email"
                  valid-feedback="Thank you :)"
                  invalid-feedback="Introduce un e-mail"
                  :is-valid="validateEmail"
                />
                <CInput
                  placeholder="Password"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  v-model="password"
                  valid-feedback="Thank you :)"
                  invalid-feedback="Introduce una contraseña correcta"
                  :is-valid="validateContraseña"
                >
                  <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                </CInput>
                <CInput
                  placeholder="Repeat password"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  class="mb-4"
                  v-model="password_confirmation"
                  valid-feedback="Thank you :)"
                  invalid-feedback="Introduce una contraseña correcta"
                  :is-valid="validateContraseña"
                >
                  <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                </CInput>
                <CButton type="submit" color="success" block>Añadir Usuario</CButton>
              </CForm>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

  <script>
    import axios from 'axios'
    export default {
      data() {
        return {
          name: '',
          email: '',
          password: '',
          password_confirmation: ''
        }
      },    
      methods: {
        validatorvacio (val){
      return val ? val.length >= 1: false
    },
    validateEmail(val) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val)) {
          return true;
      } else {
          return false;
      }
    },
    validateContraseña(val){
      const containsUppercase = /[A-Z]/.test(val)
      const containsLowercase = /[a-z]/.test(val)
      const containsNumber = /[0-9]/.test(val)
      const containsSpecial = /[#?!@$%^&*-]/.test(val)
      return containsUppercase && containsLowercase && containsNumber && containsSpecial
    },
        register() {
          var self = this;
          axios.post(  this.$apiAdress + '/api/register', {
            name: self.name,
            email: self.email,
            password: self.password,
            password_confirmation: self.password_confirmation
          }).then(function (response) {
            self.name = '';
            self.email = '';
            self.password = '';
            self.password_confirmation = '';
            console.log(response);
            self.$router.push({ path: '/users' });
          })
          .catch(function (error) {
            console.log(error);
          });
  
        }
      }
    }
  
  </script>
