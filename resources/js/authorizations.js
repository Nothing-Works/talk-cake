const user = window.shared.user

module.exports = {
    updateReply(reply) {
        return reply.user_id === user.id
    }
}
