const user = window.shared.user

module.exports = {
    owns(model, prop = 'user_id') {
        return model[prop] === user.id
    }
}
