// Store ticket data for quick access
// const ticketsData = defined in PHP

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    document.querySelectorAll('.filter-button').forEach(button => {
        button.addEventListener('click', function() {
            const filterType = this.textContent.trim();
            
            // Update active state
            document.querySelectorAll('.filter-button').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter tickets
            const ticketItems = document.querySelectorAll('.ticket-item');
            ticketItems.forEach(item => {
                let show = true;
                const badgesHtml = item.innerHTML;
                
                if (filterType === 'All Tickets') {
                    show = true;
                } else if (filterType === 'My Tickets') {
                    show = true;
                } else if (filterType === 'High Priority') {
                    show = badgesHtml.includes('badge-priority high');
                } else if (filterType === 'Open') {
                    show = badgesHtml.includes('badge-status open');
                } else if (filterType === 'Closed') {
                    show = badgesHtml.includes('badge-status closed');
                } else if (filterType === 'Resolved') {
                    show = badgesHtml.includes('badge-status resolved');
                }
                
                item.style.display = show ? 'block' : 'none';
            });
        });
    });
});

function showTicketDetail(ticketId) {
    const ticket = ticketsData.find(t => t.id == ticketId);
    if (!ticket) return;

    // Show selected ticket card on left side
    const selectedCard = document.getElementById('selectedTicketCard');
    document.getElementById('selectedTicketTitle').textContent = ticket.title;
    document.getElementById('selectedStatus').textContent = ticket.status.replace('_', ' ').toUpperCase();
    document.getElementById('selectedPriority').textContent = ticket.priority.toUpperCase();
    document.getElementById('selectedDescription').textContent = ticket.description;
    selectedCard.style.display = 'block';

    // Update badges
    const statusClass = ticket.status.replace('_', '-');
    const badgesHtml = `
        <span class="badge badge-status ${statusClass}">
            ${ticket.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}
        </span>
        <span class="badge badge-priority ${ticket.priority}">
            Priority: ${ticket.priority.charAt(0).toUpperCase() + ticket.priority.slice(1)}
        </span>
    `;
    document.getElementById('detailBadges').innerHTML = badgesHtml;

    // Update title
    document.getElementById('detailTitle').textContent = ticket.title;

    // Update description
    document.getElementById('detailDescription').innerHTML = ticket.description.replace(/\n/g, '<br>');

    // Update meta information
    const metaHtml = `
        <div class="meta-item">
            <div class="meta-label">Assignee</div>
            <div class="meta-value">${ticket.assignee_name || 'Unassigned'}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Reporter</div>
            <div class="meta-value">${ticket.reporter_name}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Created On</div>
            <div class="meta-value">${new Date(ticket.created_at).toLocaleDateString()}</div>
        </div>
        <div class="meta-item">
            <div class="meta-label">Last Updated</div>
            <div class="meta-value">${new Date(ticket.updated_at).toLocaleDateString()}</div>
        </div>
    `;
    document.getElementById('detailMeta').innerHTML = metaHtml;


}

function closeTicketDetail() {
    document.getElementById('ticketDetailOverlay').classList.remove('active');
    document.body.style.overflow = '';
}

// Close on overlay background click
document.getElementById('ticketDetailOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTicketDetail();
    }
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTicketDetail();
    }
});
