<?php
/**
 * Pi Dentist — Service Detail: Niềng trong suốt (Clear Aligners / Invisalign)
 *
 * Template part chuyên sâu cho /dich-vu/nieng-trong-suot/.
 * Render: TOC sidebar + rich content sections.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$phone = esc_html( get_theme_mod( 'pi_phone', '0909 XXX XXX' ) );
?>

<div class="service-detail__layout">

	<!-- ─── Table of Contents (sticky sidebar) ──────────────── -->
	<aside class="service-toc reveal" aria-label="Mục lục bài viết">
		<p class="service-toc__title">Mục lục</p>
		<nav class="service-toc__list">
			<a href="#tong-quan" class="service-toc__link">Tổng quan</a>
			<a href="#cau-tao" class="service-toc__link">Cấu tạo & Nguyên lý</a>
			<a href="#uu-diem" class="service-toc__link">Ưu điểm nổi bật</a>
			<a href="#phu-hop" class="service-toc__link">Ai nên niềng?</a>
			<a href="#quy-trinh" class="service-toc__link">Quy trình điều trị</a>
			<a href="#so-sanh" class="service-toc__link">So sánh phương pháp</a>
			<a href="#cam-ket" class="service-toc__link">Cam kết tại Pi</a>
		</nav>
	</aside>

	<!-- ─── Main Content Column ─────────────────────────────── -->
	<div class="service-detail__content">

		<!-- ══ Section: Tổng quan ══════════════════════════════ -->
		<section class="service-content-section reveal" id="tong-quan">
			<h2 class="service-section-heading">Tổng quan về niềng trong suốt</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Niềng trong suốt (Clear Aligners / Invisalign) là phương pháp chỉnh nha <strong>hiện đại bậc nhất</strong> hiện nay, sử dụng bộ khay nhựa trong suốt (aligner) được thiết kế riêng cho từng bệnh nhân bằng công nghệ quét 3D và phần mềm mô phỏng kỹ thuật số. Khay trong suốt có thể tháo lắp dễ dàng, gần như <strong>vô hình khi đeo</strong> — là lựa chọn hàng đầu cho những ai muốn chỉnh nha mà không ảnh hưởng đến thẩm mỹ khuôn mặt.
				</p>
				<p>
					Tại Pi Dentist, chúng tôi sử dụng hệ thống Invisalign chính hãng cùng công nghệ scan iTero — <strong>không cần lấy dấu truyền thống</strong>. Toàn bộ quá trình điều trị được mô phỏng 3D trước khi bắt đầu, giúp bệnh nhân hình dung chính xác kết quả cuối cùng ngay từ buổi tư vấn đầu tiên.
				</p>
			</div>

			<!-- Highlight box -->
			<div class="service-highlight-box">
				<p class="service-highlight-box__title">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
					Bạn biết không?
				</p>
				<p>
					Tính đến năm 2024, hệ thống Invisalign đã điều trị thành công <strong>hơn 14 triệu ca</strong> trên toàn thế giới, trở thành thương hiệu khay trong suốt được tin dùng nhất tại hơn 100 quốc gia. Tại Việt Nam, niềng trong suốt ngày càng phổ biến với tốc độ tăng trưởng hơn 30% mỗi năm.
				</p>
			</div>
		</section>

		<!-- ══ Section: Cấu tạo & Nguyên lý ═══════════════════ -->
		<section class="service-content-section reveal" id="cau-tao">
			<h2 class="service-section-heading">Cấu tạo và nguyên lý hoạt động</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Hệ thống niềng trong suốt hoạt động dựa trên nguyên lý dịch chuyển răng tuần tự, mỗi bộ khay di chuyển răng khoảng 0,25mm. Hệ thống gồm 4 thành phần chính:
				</p>
			</div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16v16H4z" rx="3"/><path d="M4 4c0 8 16 8 16 16"/></svg>
					</div>
					<div>
						<h4>Khay trong suốt (Aligner)</h4>
						<p>Được chế tạo từ nhựa y tế SmartTrack độc quyền — siêu mỏng, trong suốt, ôm sát cung hàm. Mỗi khay được thiết kế riêng bằng công nghệ 3D cho từng giai đoạn điều trị.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><circle cx="5" cy="8" r="2"/><circle cx="19" cy="8" r="2"/><circle cx="5" cy="16" r="2"/><circle cx="19" cy="16" r="2"/></svg>
					</div>
					<div>
						<h4>Attachment (Chấm composite)</h4>
						<p>Các chấm nhỏ bằng composite màu răng được gắn trên bề mặt răng, giúp tạo điểm bám và hỗ trợ lực dịch chuyển chính xác cho các chuyển động phức tạp.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/><circle cx="12" cy="10" r="3"/></svg>
					</div>
					<div>
						<h4>Phần mềm ClinCheck 3D</h4>
						<p>Công nghệ mô phỏng 3D toàn bộ quá trình dịch chuyển răng từ đầu đến cuối. Bệnh nhân được xem trước kết quả trước khi bắt đầu, bác sĩ kiểm soát từng bước chính xác tuyệt đối.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4l16 16"/><path d="M20 4L4 20"/><circle cx="12" cy="12" r="9"/></svg>
					</div>
					<div>
						<h4>Khay tháo lắp tuần tự</h4>
						<p>Mỗi bộ khay đeo 1-2 tuần rồi chuyển sang bộ tiếp theo. Mỗi khay dịch chuyển răng khoảng 0,25mm, đảm bảo chuyển động nhẹ nhàng, không đau nhức.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: Ưu điểm nổi bật ═══════════════════════ -->
		<section class="service-content-section reveal" id="uu-diem">
			<h2 class="service-section-heading">Ưu điểm nổi bật</h2>
			<div class="gold-line-left"></div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
					</div>
					<div>
						<h4>Thẩm mỹ tuyệt đối</h4>
						<p>Khay trong suốt gần như vô hình khi đeo, không ai nhận ra bạn đang niềng răng — tự tin giao tiếp mọi lúc mọi nơi.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2v6l3 3"/><circle cx="12" cy="14" r="8"/></svg>
					</div>
					<div>
						<h4>Tháo lắp tự do</h4>
						<p>Dễ dàng tháo khay khi ăn uống và vệ sinh răng miệng — không lo thức ăn dính mắc cài, không cần kiêng khem.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg>
					</div>
					<div>
						<h4>Thoải mái, không cộm trầy</h4>
						<p>Không mắc cài, không dây cung — không lo trầy xước niêm mạc, không cảm giác cộm khó chịu như niềng truyền thống.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/><path d="M7 8l3 3-3 3"/><line x1="13" y1="14" x2="17" y2="14"/></svg>
					</div>
					<div>
						<h4>Dự đoán kết quả trước</h4>
						<p>Công nghệ ClinCheck 3D mô phỏng toàn bộ quá trình — bạn xem trước nụ cười tương lai trước khi bắt đầu điều trị.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: Ai nên niềng? ═════════════════════════ -->
		<section class="service-content-section reveal" id="phu-hop">
			<h2 class="service-section-heading">Ai nên niềng trong suốt?</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Niềng trong suốt đặc biệt phù hợp với những ai ưu tiên thẩm mỹ và sự tiện lợi trong suốt quá trình điều trị:</p>
			</div>

			<div class="service-suited-list">
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người trưởng thành muốn thẩm mỹ tối đa khi chỉnh nha
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Doanh nhân, người thường xuyên giao tiếp, thuyết trình
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Ca lệch lạc nhẹ đến trung bình: thưa răng, chen chúc nhẹ, khớp cắn hở nhẹ
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người muốn tháo lắp linh hoạt khi ăn uống và vệ sinh
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người dị ứng kim loại hoặc nhạy cảm niêm mạc
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Thanh thiếu niên 13-17 tuổi với Invisalign Teen (có compliance indicator)
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người muốn xem trước kết quả trước khi quyết định điều trị
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người bận rộn — ít phải tái khám hơn niềng mắc cài
				</div>
			</div>
		</section>

		<!-- ══ Section: Quy trình điều trị ════════════════════ -->
		<section class="service-content-section reveal" id="quy-trinh">
			<h2 class="service-section-heading">Quy trình niềng trong suốt tại Pi Dentist</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Mỗi ca niềng trong suốt tại Pi Dentist đều tuân theo quy trình <strong>5 bước chuẩn hóa</strong>, kết hợp công nghệ kỹ thuật số và chuyên môn bác sĩ chỉnh nha:</p>
			</div>

			<div class="service-process-steps">
				<div class="service-step">
					<div class="service-step__number">1</div>
					<div class="service-step__content">
						<p class="service-step__title">Tư vấn & Scan 3D iTero</p>
						<p class="service-step__desc">Bác sĩ khám tổng quát, chụp X-quang panoramic + cephalometric, scan 3D iTero (không cần lấy dấu truyền thống). Dữ liệu kỹ thuật số chính xác đến từng 0,01mm được gửi trực tiếp đến phần mềm thiết kế.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">2</div>
					<div class="service-step__content">
						<p class="service-step__title">Thiết kế ClinCheck — Mô phỏng kết quả</p>
						<p class="service-step__desc">Bác sĩ sử dụng phần mềm ClinCheck để mô phỏng 3D toàn bộ quá trình dịch chuyển răng. Bệnh nhân được xem và duyệt kết quả trước khi sản xuất khay — biết trước nụ cười tương lai.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">3</div>
					<div class="service-step__content">
						<p class="service-step__title">Sản xuất bộ khay tùy chỉnh</p>
						<p class="service-step__desc">Sau khi bệnh nhân duyệt ClinCheck, dữ liệu được gửi đến Align Technology (Mỹ) để sản xuất toàn bộ bộ khay. Thời gian nhận khay khoảng 2-3 tuần, mỗi khay được chế tạo chính xác từ nhựa SmartTrack.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">4</div>
					<div class="service-step__content">
						<p class="service-step__title">Đeo khay & Tái khám định kỳ</p>
						<p class="service-step__desc">Đeo khay 20-22 giờ/ngày, thay khay mới mỗi 1-2 tuần. Tái khám mỗi 6-8 tuần để bác sĩ kiểm tra tiến trình, gắn attachment nếu cần. Mỗi lần tái khám nhanh gọn, chỉ khoảng 15-20 phút.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">5</div>
					<div class="service-step__content">
						<p class="service-step__title">Hoàn tất & Duy trì kết quả</p>
						<p class="service-step__desc">Sau khi hoàn thành bộ khay cuối cùng, bệnh nhân chuyển sang đeo Vivera retainer — hàm duy trì trong suốt chính hãng Invisalign để cố định kết quả lâu dài. Bác sĩ hẹn tái khám 3-6 tháng/lần.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: So sánh phương pháp ═══════════════════ -->
		<section class="service-content-section reveal" id="so-sanh">
			<h2 class="service-section-heading">So sánh với các phương pháp niềng khác</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Bảng so sánh nhanh giúp bạn hiểu rõ sự khác biệt giữa niềng trong suốt và các phương pháp chỉnh nha phổ biến khác:</p>
			</div>

			<div class="service-comparison-table-wrap">
				<table class="service-comparison-table">
					<thead>
						<tr>
							<th>Tiêu chí</th>
							<th>Mắc cài kim loại</th>
							<th>Mắc cài sứ</th>
							<th class="highlight-col">Niềng trong suốt</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Thẩm mỹ khi đeo</td>
							<td>★★☆☆☆</td>
							<td>★★★★☆</td>
							<td class="highlight-col"><strong>★★★★★</strong></td>
						</tr>
						<tr>
							<td>Thoải mái</td>
							<td>★★★☆☆</td>
							<td>★★★☆☆</td>
							<td class="highlight-col"><strong>★★★★★</strong></td>
						</tr>
						<tr>
							<td>Hiệu quả điều trị</td>
							<td><strong>★★★★★</strong></td>
							<td>★★★★☆</td>
							<td class="highlight-col">★★★★☆</td>
						</tr>
						<tr>
							<td>Chi phí</td>
							<td>Từ 25 triệu</td>
							<td>Từ 35 triệu</td>
							<td class="highlight-col"><strong>Từ 50 triệu</strong></td>
						</tr>
						<tr>
							<td>Thời gian điều trị</td>
							<td>18-30 tháng</td>
							<td>18-30 tháng</td>
							<td class="highlight-col"><strong>12-24 tháng</strong></td>
						</tr>
						<tr>
							<td>Xử lý ca phức tạp</td>
							<td><strong>Rất tốt</strong></td>
							<td>Tốt</td>
							<td class="highlight-col">Hạn chế</td>
						</tr>
						<tr>
							<td>Tháo lắp được</td>
							<td>Không</td>
							<td>Không</td>
							<td class="highlight-col"><strong>Có</strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>

		<!-- ══ Section: Cam kết tại Pi ════════════════════════ -->
		<section class="service-content-section reveal" id="cam-ket">
			<h2 class="service-section-heading">Cam kết khi niềng tại Pi Dentist</h2>
			<div class="gold-line-left"></div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
					</div>
					<div>
						<h4>Bảo hành kết quả</h4>
						<p>Cam kết kết quả điều trị đúng như phác đồ đã thống nhất. Nếu chưa đạt — tiếp tục điều trị miễn phí.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
					</div>
					<div>
						<h4>Trả góp 0% lãi suất</h4>
						<p>Hỗ trợ trả góp linh hoạt lên đến 12 tháng qua thẻ tín dụng, giúp tối ưu ngân sách điều trị.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
					</div>
					<div>
						<h4>Chi phí minh bạch</h4>
						<p>Báo giá trọn gói từ đầu — không phát sinh, không chi phí ẩn. Bao gồm tái khám, khay bổ sung, Vivera retainer.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
					</div>
					<div>
						<h4>Bác sĩ chuyên sâu phụ trách</h4>
						<p>Mỗi bệnh nhân được 1 bác sĩ chỉnh nha chuyên trách theo dõi từ đầu đến cuối — không chuyển tay.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Inline CTA ═════════════════════════════════════ -->
		<div class="service-inline-cta reveal">
			<h3>Sẵn sàng trải nghiệm chỉnh nha vô hình?</h3>
			<p>Đặt lịch tư vấn miễn phí để được bác sĩ scan 3D iTero, mô phỏng kết quả ClinCheck và lên phác đồ Invisalign riêng cho bạn.</p>
			<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold">
				Đặt lịch tư vấn miễn phí
				<span aria-hidden="true">→</span>
			</a>
		</div>

	</div><!-- /.service-detail__content -->

</div><!-- /.service-detail__layout -->
