import TimeAgo from 'javascript-time-ago'
// English.
import en from 'javascript-time-ago/locale/en'

export const dateFormat = (dateString) => {
    TimeAgo.addDefaultLocale(en)
    const date = new Date(dateString);

    // Create formatter (English).
    const timeAgo = new TimeAgo('en-US')

    return timeAgo.format(date);
};

