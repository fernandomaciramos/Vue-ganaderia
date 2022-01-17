<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <h3>Ganaderia id:  {{ $route.params.id }}</h3>

          <h4>
            Nombre de la Ganaderia: {{ name }}
          </h4>
          <h4>
            Email: {{ email }}
          </h4>


          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Ganaderias',
  /*
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  */
  data: () => {
    return {
      name: '',
      email:''
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
    }
  },
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/ganaderias/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        console.log("estoy en el then de ganaderia");
      self.name = response.data.name
      self.email = response.data.email
    }).catch(function (error) {
      console.log(error);
      self.$router.push({ path: '/login' })
    });
  }
}


</script>
