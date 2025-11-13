jQuery(document).ready(function($) {

    /**
     * Step switching helper
     */
    function goToStep(stepNumber) {
        $(".kpct-step-section").removeClass("kpct-step-section-active");
        $("#kpct-step-" + stepNumber).addClass("kpct-step-section-active");

        $(".kpct-step").removeClass("kpct-step-active");
        $('.kpct-step[data-step="' + stepNumber + '"]').addClass("kpct-step-active");
    }

    /**
     * Trigger search
     */
    $("#kpct-search-button").on("click", function() {
        const query = $("#kpct-search-input").val().trim();

        if (!query) {
            alert("Please enter a name or brand.");
            return;
        }

        // Clear old results
        $("#kpct-results-list").html("");

        // Show loading
        $("#kpct-results-list").html("<p>Searching...</p>");

        $.ajax({
            url: kpctData.ajaxUrl,
            method: "POST",
            data: {
                action: "kpct_search",
                nonce: kpctData.nonce,
                query: query
            },
            success: function(response) {
                if (!response.success) {
                    $("#kpct-results-list").html("<p>Error: " + response.data.message + "</p>");
                    return;
                }

                const results = response.data;

                if (!results.length) {
                    $("#kpct-results-list").html("<p>No results found. Try different wording.</p>");
                    return;
                }

                // Render cards
                let html = "";
                results.forEach(item => {
                    html += `
                        <div class="kpct-card">
                            ${item.image ? `<img src="${item.image}">` : ""}
                            <h4>${item.name}</h4>
                            <p>${item.description || "No description available."}</p>
                            <button class="kpct-btn kpct-btn-primary kpct-select-entity"
                                    data-entity='${JSON.stringify(item)}'>
                                Select
                            </button>
                        </div>
                    `;
                });

                $("#kpct-results-list").html(html);

                goToStep(2);
            },
            error: function() {
                $("#kpct-results-list").html("<p>API request failed.</p>");
            }
        });
    });

    /**
     * Back button from Step 2 → Step 1
     */
    $("#kpct-back-button").on("click", function() {
        goToStep(1);
    });

    /**
     * Select an entity → Step 3
     */
    $(document).on("click", ".kpct-select-entity", function() {
        const entity = $(this).data("entity");

        // Render selected entity overview
        $("#kpct-selected-entity").html(`
            <div>
                ${entity.image ? `<img src="${entity.image}" style="width:200px;border-radius:6px;">` : ""}
                <h3>${entity.name}</h3>
                <p><strong>Type:</strong> ${entity.type || "N/A"}</p>
                <p>${entity.description || ""}</p>
                <p><a href="${entity.url}" target="_blank">View on Google →</a></p>
            </div>
        `);

        // Simple claim instructions (expandable later)
        $("#kpct-claim-instructions").html(`
            <h3>How to Claim This Knowledge Panel</h3>
            <ol>
                <li>Open the Google result using the link above.</li>
                <li>If a Knowledge Panel appears, scroll to the bottom.</li>
                <li>Click <strong>"Claim this knowledge panel"</strong>.</li>
                <li>Sign in with your Google account.</li>
                <li>Follow Google’s verification steps.</li>
            </ol>
            <p>If you do not see a claim option, try verifying through Google Search Console or YouTube Brand Accounts.</p>
        `);

        goToStep(3);
    });

    /**
     * Start over → Step 1
     */
    $("#kpct-start-over").on("click", function() {
        $("#kpct-search-input").val("");
        $("#kpct-results-list").html("");
        $("#kpct-selected-entity").html("");
        $("#kpct-claim-instructions").html("");
        goToStep(1);
    });

});
