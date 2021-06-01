<template>
  <div>
    <CCard>
      <CCardHeader>
        <CIcon name="cil-drop"/> Theme colors
      </CCardHeader>
      <CCardBody>
        <CRow>
          <ColorTheme color="bg-primary">
            <h6>Brand Primary Color</h6>
          </ColorTheme>
          <ColorTheme color="bg-secondary"><h6>Brand Secondary Color</h6></ColorTheme>
          <ColorTheme color="bg-success"><h6>Brand Success Color</h6></ColorTheme>
          <ColorTheme color="bg-danger"><h6>Brand Danger Color</h6></ColorTheme>
          <ColorTheme color="bg-warning"><h6>Brand Warning Color</h6></ColorTheme>
          <ColorTheme color="bg-info"><h6>Brand Info Color</h6></ColorTheme>
          <ColorTheme color="bg-light"><h6>Brand Light Color</h6></ColorTheme>
          <ColorTheme color="bg-dark"><h6>Brand Dark Color</h6></ColorTheme>
        </CRow>
      </CCardBody>
    </CCard>
    <CCard>
      <CCardHeader>
        <CIcon name="cil-drop"/> Grays
      </CCardHeader>
      <CCardBody>
        <CRow>
          <ColorTheme color="bg-gray-100"><h6>Brand 100 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-200"><h6>Brand 200 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-300"><h6>Brand 300 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-400"><h6>Brand 400 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-500"><h6>Brand 500 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-600"><h6>Brand 600 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-700"><h6>Brand 700 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-800"><h6>Brand 800 Color</h6></ColorTheme>
          <ColorTheme color="bg-gray-900"><h6>Brand 900 Color</h6></ColorTheme>
        </CRow>
      </CCardBody>
    </CCard>
  <CDataTable
    class="mb-0 table-outline"
    hover
    :items="tableItems"
    :fields="tableFields"
    head-color="light"
    no-sorting
  >
    <td slot="avatar" class="text-center" slot-scope="{item}">
      <div class="c-avatar">
        <img :src="item.avatar.url" class="c-avatar-img" alt="">
        <span
          class="c-avatar-status"
          :class="`bg-${item.avatar.status || 'secondary'}`"
        ></span>
      </div>
    </td>
    <td slot="user" slot-scope="{item}">
      <div>{{item.user.name}}</div>
      <div class="small text-muted">
        <span>
          <template v-if="item.user.new">New</template>
          <template v-else>Recurring</template>
        </span> | Registered: {{item.user.registered}}
      </div>
    </td>
    <td
      slot="country"
      slot-scope="{item}"
      class="text-center"
    >
      <CIcon
        :name="item.country.flag"
        height="25"
      />
    </td>
    <td slot="usage" slot-scope="{item}">
      <div class="clearfix">
        <div class="float-left">
          <strong>{{item.usage.value}}%</strong>
        </div>
        <div class="float-right">
          <small class="text-muted">{{item.usage.period}}</small>
        </div>
      </div>
      <CProgress
        class="progress-xs"
        v-model="item.usage.value"
        :color="color(item.usage.value)"
      />
  </td>
  <td
    slot="payment"
    slot-scope="{item}"
    class="text-center"
  >
    <CIcon
      :name="item.payment.icon"
      height="25"
    />
  </td>
  <td slot="activity" slot-scope="{item}">
    <div class="small text-muted">Last login</div>
    <strong>{{item.activity}}</strong>
  </td>
  </CDataTable>
  </div>
</template>

<script>
import ColorTheme from './ColorTheme'

export default {
  name: 'Colors',
  components: { ColorTheme },
  data () {
    return {
      selected: 'Month',
      tableItems: [
        {
          avatar: { url: 'img/avatars/1.jpg', status: 'success' },
          user: { name: 'Yiorgos Avraamu', new: true, registered: 'Jan 1, 2015' },
          country: { name: 'USA', flag: 'cif-us' },
          usage: { value: 50, period: 'Jun 11, 2015 - Jul 10, 2015' },
          payment: { name: 'Mastercard', icon: 'cib-cc-mastercard' },
          activity: '10 sec ago'
        },
        {
          avatar: { url: 'img/avatars/2.jpg', status: 'danger' },
          user: { name: 'Avram Tarasios', new: false, registered: 'Jan 1, 2015' },
          country: { name: 'Brazil', flag: 'cif-br' },
          usage: { value: 22, period: 'Jun 11, 2015 - Jul 10, 2015' },
          payment: { name: 'Visa', icon: 'cib-cc-visa' },
          activity: '5 minutes ago'
        },
        {
          avatar: { url: 'img/avatars/3.jpg', status: 'warning' },
          user: { name: 'Quintin Ed', new: true, registered: 'Jan 1, 2015' },
          country: { name: 'India', flag: 'cif-in' },
          usage: { value: 74, period: 'Jun 11, 2015 - Jul 10, 2015' },
          payment: { name: 'Stripe', icon: 'cib-stripe' },
          activity: '1 hour ago'
        },
        {
          avatar: { url: 'img/avatars/4.jpg', status: '' },
          user: { name: 'Enéas Kwadwo', new: true, registered: 'Jan 1, 2015' },
          country: { name: 'France', flag: 'cif-fr' },
          usage: { value: 98, period: 'Jun 11, 2015 - Jul 10, 2015' },
          payment: { name: 'PayPal', icon: 'cib-paypal' },
          activity: 'Last month'
        },
        {
          avatar: { url: 'img/avatars/5.jpg', status: 'success' },
          user: { name: 'Agapetus Tadeáš', new: true, registered: 'Jan 1, 2015' },
          country: { name: 'Spain', flag: 'cif-es' },
          usage: { value: 22, period: 'Jun 11, 2015 - Jul 10, 2015' },
          payment: { name: 'Google Wallet', icon: 'cib-google-pay' },
          activity: 'Last week'
        },
        {
          avatar: { url: 'img/avatars/6.jpg', status: 'danger' },
          user: { name: 'Friderik Dávid', new: true, registered: 'Jan 1, 2015' },
          country: { name: 'Poland', flag: 'cif-pl' },
          usage: { value: 43, period: 'Jun 11, 2015 - Jul 10, 2015' },
          payment: { name: 'Amex', icon: 'cib-cc-amex' },
          activity: 'Last week'
        }
      ],
      tableFields: [
        { key: 'avatar', label: '', _classes: 'text-center' },
        { key: 'user' },
        { key: 'country', _classes: 'text-center' },
        { key: 'usage' },
        { key: 'payment', label: 'Payment method', _classes: 'text-center' },
        { key: 'activity' },
      ]
    }
  },
  methods: {
    color (value) {
      let $color
      if (value <= 25) {
        $color = 'info'
      } else if (value > 25 && value <= 50) {
        $color = 'success'
      } else if (value > 50 && value <= 75) {
        $color = 'warning'
      } else if (value > 75 && value <= 100) {
        $color = 'danger'
      }
      return $color
    }
  }
}

</script>
