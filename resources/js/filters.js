import Vue from 'vue'

Vue.filter('fixDurationHumanize', (datetime) => {
    if (datetime === undefined) {
        return '-'
    }

    let now = window.timezone ? moment.utc(new Date()).tz(window.timezone) : moment.utc(new Date())
    let end = window.timezone ? moment.utc(datetime).tz(window.timezone) : moment.utc(datetime)
    let duration = moment.duration(now.diff(end))
    let as_seconds = duration.asSeconds()

    return moment.duration(as_seconds, "seconds").humanize()
})

Vue.filter('fixDurationUTCRelative', (dt) => {
    if (dt) {
        let now = moment.utc()
        let datetime = moment.utc(dt)
        let duration = now.diff(datetime, 'seconds')

        if (moment.duration(duration, 'seconds').hours() >= 1) {
            return moment.duration(duration, 'seconds').format('HH:mm:ss', {
                trim: false
            })
        } else {
            return moment.duration(duration, 'seconds').format('mm:ss', {
                trim: false
            })
        }
    } else {
        return ''
    }
})
