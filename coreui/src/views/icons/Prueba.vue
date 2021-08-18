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
                >
                  <template #prepend-content><CIcon name="cil-user"/></template>
                </CInput>
                <CInput
                  placeholder="Email"
                  prepend="@"
                  autocomplete="email"
                  v-model="email"
                />
                <CInput
                  placeholder="Password"
                  type="password"
                  prependHtml="<i class='cui-lock-locked'></i>"
                  autocomplete="new-password"
                  v-model="password"
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
