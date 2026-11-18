/* City Up starts without example data. Records persist in this browser only. */
const STORAGE_KEY='cityup_items_v1';
const TYPES=['Business','Event','Activity','Urban Service','Promotion','User'];
function allEntries(){try {const a=JSON.parse(localStorage.getItem(STORAGE_KEY)||'[]');return Array.isArray(a)?a:[]} catch{return []}}
function storeEntries(a){localStorage.setItem(STORAGE_KEY,JSON.stringify(a))}
const plural={Business:'Businesses',Event:'Events',Activity:'Activities','Urban Service':'Urban Services',Promotion:'Promotions',User:'Users'};
let activeFilter='Businesses';
function escapeHTML(s){return String(s).replace(/[&<>"']/g,ch=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[ch]))}
function renderFront(){
 const container=document.getElementById('cards');if(!container)return;
 const q=(document.getElementById('main-search')?.value||'').trim().toLowerCase();
 const entries=allEntries().filter(e=>e.type!=='User'&&e.type!=='Promotion'&&plural[e.type]===activeFilter&&(!q||[e.name,e.category,e.location].join(' ').toLowerCase().includes(q)));
 container.innerHTML=entries.map(e=>`<article class="place-card" data-category="${escapeHTML(activeFilter)}"><div style="height:125px;background:linear-gradient(135deg,#e2f1ff,#f3f8ff);display:grid;place-items:center;color:#2578cd;font-size:38px"><i class="fa-solid ${e.type==='Event'?'fa-calendar-days':e.type==='Activity'?'fa-person-running':e.type==='Urban Service'?'fa-landmark':'fa-store'}"></i></div><div class="place-detail"><h3>${escapeHTML(e.name)}</h3><p>${escapeHTML(e.category||e.location||e.type)}</p></div></article>`).join('');
 const msg=document.querySelector('.empty-message');if(msg){msg.hidden=entries.length>0;msg.textContent=q?'No matching '+activeFilter.toLowerCase()+' found.':'No '+activeFilter.toLowerCase()+' added yet.'}
}
function filterCards(){renderFront()}
document.querySelectorAll('[data-filter]').forEach(el=>el.addEventListener('click',()=>{
 activeFilter=el.dataset.filter;
 document.querySelectorAll('.filter').forEach(btn=>btn.classList.toggle('active',btn.dataset.filter===activeFilter));
 if(document.getElementById('main-search'))document.getElementById('main-search').value='';
 renderFront();
}));
function renderAdmin(){
 if(!document.querySelector('.admin-page'))return;
 const entries=allEntries();
 document.querySelectorAll('.stat-card').forEach(card=>{
  const type=card.querySelector('span')?.textContent.trim();const count=entries.filter(e=>plural[e.type]===type).length;
  card.querySelector('strong').textContent=count.toLocaleString('en-US');
 });
 const total=entries.filter(e=>['Business','Event','Activity','Urban Service'].includes(e.type)).length;
 document.querySelector('.donut strong').textContent=total;
 const cats=['Business','Event','Activity','Urban Service'];
 const nums=cats.map(t=>entries.filter(e=>e.type===t).length);
 const colors=['#2585ef','#32b967','#ffba0a','#895ce2'];
 let sofar=0;const stops=[];
 nums.forEach((n,i)=>{if(n){const next=sofar+n/total*100;stops.push(`${colors[i]} ${sofar}% ${next}%`);sofar=next}});
 document.querySelector('.donut').style.background=stops.length?`conic-gradient(${stops.join(',')})`:'#e8edf5';
 document.querySelectorAll('.category-legend span').forEach((span,i)=>{span.textContent=`${plural[cats[i]]} (${total?Math.round(nums[i]/total*100):0}%)`});
 function table(id,type,empty){const body=document.querySelector('#'+id+' tbody');const records=entries.filter(e=>e.type===type).slice(-4).reverse();body.innerHTML=records.map(e=>type==='Business'?`<tr><td><b>${escapeHTML(e.name)}</b></td><td>${escapeHTML(e.category||'—')}</td><td><span class="status active">Active</span></td><td>${escapeHTML(e.created)}</td></tr>`:`<tr><td><b>${escapeHTML(e.name)}</b></td><td>${escapeHTML(e.date||'—')}</td><td>${escapeHTML(e.location||'—')}</td></tr>`).join('')||`<tr><td class="no-records" colspan="4">${empty}</td></tr>`}
 table('recent','Business','No businesses added yet.');table('events','Event','No events added yet.');
}
let modalType='Business';
function openAddModal(type){
 if(!TYPES.includes(type))return;
 modalType=type;const modal=document.getElementById('add-modal');if(!modal)return;
 modal.hidden=false;
 document.getElementById('modal-title').textContent=type==='Promotion'?'Create Promotion':'Add '+type;
 document.querySelector('.entry-category').hidden=!['Business','Activity','Urban Service'].includes(type);
 document.querySelector('.entry-location').hidden=type==='User'||type==='Promotion';
 document.querySelector('.entry-date').hidden=type!=='Event';
 document.getElementById('add-form').reset();document.getElementById('entry-name').focus();
}
function closeAddModal(){const modal=document.getElementById('add-modal');if(modal)modal.hidden=true}
const form=document.getElementById('add-form');
if(form)form.addEventListener('submit',e=>{
 e.preventDefault();const data=new FormData(form);
 const name=String(data.get('name')||'').trim();if(!name)return;
 const entry={id:Date.now(),type:modalType,name,category:String(data.get('category')||'').trim(),location:String(data.get('location')||'').trim(),date:String(data.get('date')||''),created:new Date().toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})};
 const all=allEntries();all.push(entry);
 try{storeEntries(all)}catch{alert('Could not save in this browser.');return}
 closeAddModal();renderAdmin();
});
document.getElementById('add-modal')?.addEventListener('click',e=>{if(e.target.id==='add-modal')closeAddModal()});
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeAddModal()});
renderFront();renderAdmin();
