import TimeAgo from 'javascript-time-ago'

export const dateFormat = (dateString) => {
    const date = new Date(dateString);

    // Create formatter (English).
    const timeAgo = new TimeAgo('en-US')

    return timeAgo.format(date);
};

