import { Controller } from "@hotwired/stimulus"

export default class Search extends Controller {
    static targets = ["input", "hidden", "results"];
    static classes = ["selected"];
    static values = {
        url: String,
        delay: { type: Number, default: 300 },
    }

    connect() {
        this.onInputChange = debounce(this.onInputChange, this.delayValue);
        this.inputTarget.addEventListener("input", this.onInputChange);

        if (this.inputTarget.hasAttribute("autofocus")) {
            this.inputTarget.focus();
        }
    }

    disconnect() {
        this.inputTarget.removeEventListener("input", this.onInputChange);
    }

    onInputChange = () => {
        this.hiddenTarget.value = "";

        const query = this.inputTarget.value.trim();
        if (query) {
            this.fetchResults(query);
        } else {
            this.resultsTarget.innerHTML = null;
        }
    }

    fetchResults = async (query) => {
        if (!this.hasUrlValue) return

        const url = this.buildURL(query);
        try {
            const html = await this.doFetch(url);
            this.resultsTarget.innerHTML = html;
        } catch(error) {
            throw error;
        }
    }

    buildURL(query) {
        const url = new URL(this.urlValue, window.location.href);
        const params = new URLSearchParams(url.search.slice(1));
        params.append("search", query);
        url.search = params.toString();

        return url.toString();
    }

    doFetch = async (url) => {
        const response = await fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } });

        if (!response.ok) {
            throw new Error(`Server responded with status ${response.status}`);
        }

        return await response.text();
    }
}

const debounce = (fn, delay = 10) => {
    let timeoutId = null

    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(fn, delay);
    }
}

export { Search }
