const { Given, When, Then } = require('@cucumber/cucumber')

const onPage = async function (uri) {
    return await this.page.goto('http://192.168.0.24:3000' + uri)
}

Given('I am a guest user', function () {})

Given('I am on {string} page', { wrapperOptions: { retry: 2 }, timeout: 30000 }, onPage)

When('I open {string} page', { wrapperOptions: { retry: 2 }, timeout: 30000 }, onPage)

Then('I see {string} element', async function (id) {
    await this.page.waitForSelector('[data-testid=' + id + ']')
})

Then('I click {string} element', async function (id) {
    await this.page.click('[data-testid=' + id + ']')
})

Then('I see {string}', async function (value) {
    await this.page.waitForFunction(
        (text) => {
            const el = document.querySelector('div')
            return el ? el.innerText.includes(text) : false
        },
        {},
        value
    )
})
