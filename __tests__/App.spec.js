import { mount } from '@vue/test-utils'
import App from './App'

describe('App', () => {
  test('É uma instancia de Vue', () => {
    const wrapper = mount(App)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
