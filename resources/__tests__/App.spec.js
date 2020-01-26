// import { mount } from '@vue/test-utils'
import { shallowMount } from '@vue/test-utils'
import App from '../App'

describe('App', () => {
  test('App.vue é uma instancia de Vue', () => {
    // const wrapper = mount(App)
    const wrapper = shallowMount(App)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
