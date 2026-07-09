import sys
sys.path.insert(0, "/home/claude/vt_site")
from build_site import write_page
from pages_home import HOME
from pages_about import ABOUT
from pages_services import SERVICES
from pages_industries_portfolio import INDUSTRIES, PORTFOLIO
from pages_leadership_ceo import LEADERSHIP, CEO
from pages_insights_contact import INSIGHTS, CONTACT

write_page("index.html", "Home", "Engineering precision, cinematic storytelling — Visual Triangle Media Services.", "index.html", HOME)
write_page("about.html", "About", "A premium creative studio combining cinematic storytelling with strategic communication.", "about.html", ABOUT)
write_page("services.html", "Services", "Corporate documentary, commercial production, post production, digital experience and digital marketing.", "services.html", SERVICES)
write_page("industries.html", "Industries", "Aerospace, manufacturing, automotive, construction, energy, healthcare, education and entertainment.", "industries.html", INDUSTRIES)
write_page("portfolio.html", "Portfolio", "Feature films, documentaries, corporate films, commercials, digital campaigns and motion graphics.", "portfolio.html", PORTFOLIO)
write_page("leadership.html", "Leadership & Creative Council", "A council of acclaimed film professionals strengthening Visual Triangle's creative direction.", "leadership.html", LEADERSHIP)
write_page("ceo.html", "CEO", "Akhil Prakash, Founder & CEO of Visual Triangle — Film Editor & Colorist, 14 years across feature films, documentaries and corporate storytelling.", "ceo.html", CEO)
write_page("insights.html", "Insights", "Filmmaking, storytelling, corporate communication, editing, AI, visual strategy and digital marketing.", "insights.html", INSIGHTS)
write_page("contact.html", "Contact", "Let's build something extraordinary — get in touch with Visual Triangle Media Services.", "contact.html", CONTACT)

print("ALL DONE")
