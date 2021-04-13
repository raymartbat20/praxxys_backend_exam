
export const getToken = () => localStorage.getItem('token');

export const labelParser = (label) => {
    const parser = new DOMParser();
    return parser.parseFromString(label,'text/html').body.textContent;
}