import { shallowMount } from '@vue/test-utils'
import Login from '../components/pages/login'

describe('Login', () => {
  test('login.vue é uma instancia de Vue', () => {
    const wrapper = shallowMount(Login)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
